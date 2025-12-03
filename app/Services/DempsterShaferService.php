<?php

namespace App\Services;

use App\Models\DsRule;
use App\Models\Penyakit;

/**
 * Service untuk perhitungan kombinasi evidence menggunakan teori Dempster-Shafer
 *
 * Implementasi teori Dempster-Shafer yang akurat dengan:
 * - Mass function untuk setiap gejala
 * - Kombinasi evidence menggunakan rumus Dempster-Shafer
 * - Perhitungan konflik (K) dalam sistem
 * - Normalisasi hasil kombinasi
 *
 * @author Sistem Pakar CF
 * @version 2.0
 */
class DempsterShaferService
{
    /**
     * Kombinasi Dempster-Shafer untuk menggabungkan nilai densitas (metode lama)
     *
     * @param array $densitasResults Array hasil perhitungan densitas fuzzy
     * @return array Array penyakit dengan nilai belief
     */
    public function combineEvidence($densitasResults)
    {
        // Ambil semua penyakit yang memiliki rules
        $penyakitIds = DsRule::distinct()->pluck('penyakit_id')->toArray();
        $penyakitBeliefs = [];

        foreach ($penyakitIds as $penyakitId) {
            $belief = $this->calculatePenyakitBelief($penyakitId, $densitasResults);
            $penyakitBeliefs[$penyakitId] = $belief;
        }

        return $penyakitBeliefs;
    }

    /**
     * Kombinasi Dempster-Shafer yang akurat sesuai teori
     *
     * Implementasi teori Dempster-Shafer yang benar dengan:
     * 1. Hitung mass function untuk setiap GEJALA (bukan penyakit)
     * 2. Setiap gejala adalah satu evidence yang bisa mendukung multiple penyakit
     * 3. Kombinasi evidence menggunakan rumus: m12(A) = (Σ m1(X) * m2(Y)) / (1 - K)
     * 4. Hitung konflik K = Σ m1(X) * m2(Y) untuk X∩Y = ∅
     * 5. Normalisasi hasil kombinasi
     *
     * @param array $densitasResults Array hasil perhitungan densitas fuzzy
     *                              Format: [gejala_id => ['densitas' => float]]
     * @return array Array dengan hasil kombinasi evidence
     *               Format: [
     *                   'penyakit_beliefs' => [penyakit_id => belief_value],
     *                   'combined_mass' => [penyakit_id => mass_value],
     *                   'total_conflict' => float
     *               ]
     *
     * @example
     * $densitasResults = [
     *     1 => ['densitas' => 0.8],  // Gejala 1
     *     2 => ['densitas' => 0.6],  // Gejala 2
     *     3 => ['densitas' => 0.7]    // Gejala 3
     * ];
     * $result = $service->combineEvidenceAccurate($densitasResults);
     * echo "Diagnosis utama: " . $result['penyakit_beliefs'][1];
     */
    public function combineEvidenceAccurate($densitasResults)
    {
        // Hitung mass function untuk setiap GEJALA yang dipilih
        $massFunctions = [];
        foreach ($densitasResults as $gejalaId => $data) {
            $massFunctions[$gejalaId] = $this->calculateMassFunctionPerGejala($gejalaId, $data['densitas']);
        }

        // Kombinasi semua evidence menggunakan Dempster-Shafer
        $combinedResult = $this->combineAllEvidence($massFunctions);
        $combinedMass = $combinedResult['beliefs'];
        $totalConflict = $combinedResult['K'];

        // Hitung belief untuk setiap penyakit
        $penyakitBeliefs = [];
        $allPenyakitIds = DsRule::distinct()->pluck('penyakit_id')->toArray();
        foreach ($allPenyakitIds as $penyakitId) {
            $penyakitBeliefs[$penyakitId] = $combinedMass[$penyakitId] ?? 0;
        }

        return [
            'penyakit_beliefs' => $penyakitBeliefs,
            'combined_mass' => $combinedMass,
            'total_conflict' => $totalConflict  // K dari kombinasi DS terakhir
        ];
    }

    /**
     * Hitung belief untuk satu penyakit menggunakan kombinasi Dempster-Shafer (metode lama)
     */
    private function calculatePenyakitBelief($penyakitId, $densitasResults)
    {
        // Ambil semua rules untuk penyakit ini
        $rules = DsRule::where('penyakit_id', $penyakitId)->get();

        if ($rules->isEmpty()) {
            return 0;
        }

        $totalBelief = 0;
        $count = 0;

        foreach ($rules as $rule) {
            if (isset($densitasResults[$rule->gejala_id])) {
                $densitas = $densitasResults[$rule->gejala_id]['densitas'];

                // Mapping keunikan ke nilai numerik untuk perhitungan
                $keunikanValues = ['Rendah' => 0.3, 'Sedang' => 0.5, 'Tinggi' => 0.8];
                $keunikanValue = $keunikanValues[$rule->keunikan] ?? 0.5;

                // Hitung belief berdasarkan densitas fuzzy dan keunikan
                // Formula: belief = densitas * keunikan
                $belief = $densitas * $keunikanValue;

                $totalBelief += $belief;
                $count++;
            }
        }

        // Rata-rata belief untuk penyakit ini
        return $count > 0 ? $totalBelief / $count : 0;
    }

    /**
     * Hitung mass function untuk satu GEJALA berdasarkan densitas dan penyakit yang berhubungan
     *
     * Dalam teori Dempster-Shafer yang benar:
     * - Setiap gejala adalah satu evidence
     * - Satu gejala bisa mendukung multiple penyakit
     * - Mass function berbentuk: m({P1, P2, ...}) = densitas * keunikan
     * - m({θ}) = 1 - densitas (ketidaktahuan)
     */
    private function calculateMassFunctionPerGejala($gejalaId, $densitas)
    {
        // Ambil semua penyakit yang berhubungan dengan gejala ini
        $rules = DsRule::with('fuzzyParameter')->where('gejala_id', $gejalaId)->get();

        if ($rules->isEmpty()) {
            return [
                'penyakit' => [],
                'theta' => 1.0  // θ = ketidaktahuan
            ];
        }

        $massFunction = [
            'penyakit' => [],
            'theta' => 1.0
        ];

        // Hitung total keunikan untuk normalisasi
        $totalKeunikan = 0;
        $penyakitKeunikan = [];

        foreach ($rules as $rule) {
            // Get keunikan label from fuzzyParameter relation or accessor
            $keunikanLabel = $rule->keunikan ?? 'Sedang';
            // Get nilai from FuzzyParameter model
            $keunikanValue = \App\Models\FuzzyParameter::getNilaiByLabel('keunikan', $keunikanLabel);

            $penyakitKeunikan[$rule->penyakit_id] = $keunikanValue;
            $totalKeunikan += $keunikanValue;
        }

        // Distribusi mass yang proporsional berdasarkan keunikan
        $totalMass = 0;

        foreach ($penyakitKeunikan as $penyakitId => $keunikanValue) {
            // Mass proporsional: densitas * (keunikan / total_keunikan)
            $penyakitMass = $densitas * ($keunikanValue / $totalKeunikan);
            $massFunction['penyakit'][$penyakitId] = $penyakitMass;
            $totalMass += $penyakitMass;
        }

        // Theta (ketidaktahuan) = 1 - total mass yang didistribusikan
        $massFunction['theta'] = 1.0 - $totalMass;

        return $massFunction;
    }

    /**
     * Kombinasi semua evidence menggunakan rumus Dempster-Shafer
     *
     * Menangani mass function yang bisa berisi:
     * - Single penyakit: {P1}
     * - Multiple penyakit: {P1,P2,P3}
     * - Theta: {θ}
     *
     * @return array Array dengan 'beliefs' dan 'K' (total conflict dari kombinasi terakhir)
     */
    private function combineAllEvidence($massFunctions)
    {
        if (empty($massFunctions)) {
            return ['beliefs' => [], 'K' => 0.0];
        }

        // Jika hanya ada satu evidence, tidak ada konflik (K = 0)
        if (count($massFunctions) == 1) {
            $firstMass = reset($massFunctions);
            return [
                'beliefs' => $this->extractPenyakitBeliefs($firstMass),
                'K' => 0.0
            ];
        }

        // Kombinasi berurutan menggunakan rumus Dempster-Shafer
        // Contoh: m1 ⊕ m2 → K12, kemudian (m1 ⊕ m2) ⊕ m3 → K123
        // K yang dikembalikan adalah K dari kombinasi terakhir (K123)
        // karena itulah K yang digunakan untuk normalisasi hasil akhir
        $currentMass = null;
        $finalK = 0.0;

        foreach ($massFunctions as $gejalaId => $massFunction) {
            if ($currentMass === null) {
                $currentMass = $massFunction;
                // Inisialisasi: tidak ada konflik pada evidence pertama (K = 0)
                $finalK = 0.0;
                continue;
            }

            // Kombinasi evidence menggunakan rumus DS
            // Hasil kombinasi berisi K (konflik) dari kombinasi ini
            $combinedResult = $this->combineTwoEvidence($currentMass, $massFunction);
            $currentMass = $combinedResult;
            // Update K dengan nilai K dari kombinasi terakhir
            // K ini adalah konflik yang digunakan untuk normalisasi pada kombinasi ini
            $finalK = $combinedResult['K'] ?? 0.0;
        }

        // Ekstrak hasil untuk setiap penyakit
        return [
            'beliefs' => $this->extractPenyakitBeliefs($currentMass),
            'K' => $finalK
        ];
    }

    /**
     * Ekstrak belief untuk setiap penyakit dari mass function
     */
    private function extractPenyakitBeliefs($massFunction)
    {
        $penyakitBeliefs = [];

        if (!isset($massFunction['penyakit'])) {
            return $penyakitBeliefs;
        }

        foreach ($massFunction['penyakit'] as $key => $mass) {
            $penyakitIds = $this->parsePenyakitKey($key);

            if (count($penyakitIds) == 1) {
                // Single penyakit
                $penyakitBeliefs[$penyakitIds[0]] = $mass;
            } else {
                // Multiple penyakit - distribusi mass secara proporsional
                // Dalam kasus ini, mass sudah didistribusikan secara proporsional
                // berdasarkan keunikan di level gejala, jadi tidak perlu dibagi lagi
                foreach ($penyakitIds as $penyakitId) {
                    $penyakitBeliefs[$penyakitId] = ($penyakitBeliefs[$penyakitId] ?? 0) + $mass;
                }
            }
        }

        return $penyakitBeliefs;
    }

    /**
     * Kombinasi dua evidence menggunakan rumus Dempster-Shafer
     *
     * Menangani subset intersection yang lengkap:
     * - {P1} ∩ {P2} = ∅ (konflik)
     * - {P1} ∩ {P1,P2} = {P1} (intersection)
     * - {P1,P2} ∩ {P2,P3} = {P2} (subset intersection)
     */
    private function combineTwoEvidence($mass1, $mass2)
    {
        $result = [
            'penyakit' => [],
            'theta' => 0,
            'K' => 0.0
        ];

        // Hitung konflik (K) sesuai teori Dempster-Shafer
        // K = Σ m1(X) × m2(Y) untuk semua X ∩ Y = ∅ (intersection kosong)
        // Catatan: theta (θ) adalah universal set, jadi kombinasi dengan theta tidak menghasilkan konflik
        $conflict = 0;

        // Konflik terjadi ketika intersection antara dua subset penyakit adalah kosong
        foreach ($mass1['penyakit'] ?? [] as $key1 => $value1) {
            foreach ($mass2['penyakit'] ?? [] as $key2 => $value2) {
                $intersection = $this->getIntersection($key1, $key2);
                if (empty($intersection)) {
                    // Intersection kosong = konflik, tambahkan ke total konflik
                    $conflict += $value1 * $value2;
                }
            }
        }

        // Hitung normalisasi factor (1 - K)
        $normalizationFactor = 1 - $conflict;

        if ($normalizationFactor <= 0) {
            // Jika konflik terlalu tinggi, return mass function dengan theta = 1
            return [
                'penyakit' => [],
                'theta' => 1.0,
                'K'=> 1.0
            ];
        }

        // Kombinasi untuk setiap subset intersection
        $allCombinations = $this->getAllSubsetCombinations($mass1, $mass2);

        foreach ($allCombinations as $combination => $mass) {
            if ($mass > 0) {
                $result['penyakit'][$combination] = $mass / $normalizationFactor;
            }
        }

        // Hitung theta untuk hasil kombinasi
        $result['theta'] = (($mass1['theta'] ?? 0) * ($mass2['theta'] ?? 0)) / $normalizationFactor;

        // Simpan nilai K (conflict) ke result
        $result['K'] = $conflict;

        return $result;
    }

    /**
     * Dapatkan semua kombinasi subset dari dua mass function
     */
    private function getAllSubsetCombinations($mass1, $mass2)
    {
        $combinations = [];

        // Kombinasi setiap subset dari mass1 dengan setiap subset dari mass2
        foreach ($mass1['penyakit'] ?? [] as $key1 => $value1) {
            foreach ($mass2['penyakit'] ?? [] as $key2 => $value2) {
                $intersection = $this->getIntersection($key1, $key2);

                if (!empty($intersection)) {
                    $combinationKey = $this->createCombinationKey($intersection);
                    $combinations[$combinationKey] = ($combinations[$combinationKey] ?? 0) + ($value1 * $value2);
                }
            }

            // Kombinasi dengan theta dari mass2
            if (isset($mass2['theta']) && $mass2['theta'] > 0) {
                $combinationKey = $key1;
                $combinations[$combinationKey] = ($combinations[$combinationKey] ?? 0) + ($value1 * $mass2['theta']);
            }
        }

        // Kombinasi theta dari mass1 dengan setiap subset dari mass2
        if (isset($mass1['theta']) && $mass1['theta'] > 0) {
            foreach ($mass2['penyakit'] ?? [] as $key2 => $value2) {
                $combinationKey = $key2;
                $combinations[$combinationKey] = ($combinations[$combinationKey] ?? 0) + ($mass1['theta'] * $value2);
            }
        }

        return $combinations;
    }

    /**
     * Dapatkan intersection antara dua key penyakit
     */
    private function getIntersection($key1, $key2)
    {
        $penyakit1 = $this->parsePenyakitKey($key1);
        $penyakit2 = $this->parsePenyakitKey($key2);

        return array_intersect($penyakit1, $penyakit2);
    }

    /**
     * Cek apakah dua key penyakit memiliki intersection
     */
    private function hasIntersection($key1, $key2)
    {
        $intersection = $this->getIntersection($key1, $key2);
        return !empty($intersection);
    }

    /**
     * Parse key penyakit menjadi array ID
     */
    private function parsePenyakitKey($key)
    {
        if (is_numeric($key)) {
            return [intval($key)];
        } elseif (strpos($key, ',') !== false) {
            return array_map('intval', explode(',', $key));
        }
        return [];
    }

    /**
     * Buat key kombinasi dari array penyakit
     */
    private function createCombinationKey($penyakitIds)
    {
        if (empty($penyakitIds)) {
            return '';
        }

        $penyakitIds = array_unique($penyakitIds);
        sort($penyakitIds);

        if (count($penyakitIds) == 1) {
            return (string)$penyakitIds[0];
        } else {
            return implode(',', $penyakitIds);
        }
    }

    /**
     * Hitung total konflik dalam sistem (metode akurat)
     */
    private function calculateTotalConflictAccurate($massFunctions)
    {
        if (count($massFunctions) < 2) {
            return 0;
        }

        $totalConflict = 0;
        $massFunctionArray = array_values($massFunctions);

        // Hitung konflik antara setiap pasangan evidence
        for ($i = 0; $i < count($massFunctionArray); $i++) {
            for ($j = $i + 1; $j < count($massFunctionArray); $j++) {
                $conflict = $this->calculateConflictBetweenEvidence($massFunctionArray[$i], $massFunctionArray[$j]);
                $totalConflict += $conflict;
            }
        }

        return $totalConflict;
    }

    /**
     * Hitung konflik antara dua evidence
     */
    private function calculateConflictBetweenEvidence($mass1, $mass2)
    {
        // Konflik dihitung berdasarkan perbedaan belief
        $conflict = 0;

        if (isset($mass1['theta']) && isset($mass2['theta'])) {
            $conflict += $mass1['theta'] * $mass2['theta'];
        }

        return $conflict;
    }


    /**
     * Hitung top 3 penyakit dengan belief tertinggi
     */
    public function getTopPenyakit($penyakitBeliefs, $limit = 3)
    {
        // Urutkan berdasarkan belief (descending)
        arsort($penyakitBeliefs);

        $topPenyakit = [];
        $count = 0;

        foreach ($penyakitBeliefs as $penyakitId => $belief) {
            if ($count >= $limit) break;

            if ($belief > 0) {
                $penyakit = Penyakit::find($penyakitId);
                if ($penyakit) {
                    $topPenyakit[] = [
                        'penyakit' => $penyakit,
                        'belief' => $belief
                    ];
                    $count++;
                }
            }
        }

        return $topPenyakit;
    }

    /**
     * Dapatkan detail hasil kombinasi evidence dengan informasi lengkap
     */
    public function getDetailedResults($densitasResults)
    {
        $results = $this->combineEvidenceAccurate($densitasResults);

        // Ambil informasi penyakit
        $penyakitDetails = [];
        foreach ($results['penyakit_beliefs'] as $penyakitId => $belief) {
            $penyakit = Penyakit::find($penyakitId);
            if ($penyakit) {
                $penyakitDetails[] = [
                    'id' => $penyakitId,
                    'nama' => $penyakit->penyakit,
                    'kode' => $penyakit->kode_penyakit,
                    'belief' => $belief,
                    'mass_value' => $results['combined_mass'][$penyakitId] ?? 0
                ];
            }
        }

        // Urutkan berdasarkan belief
        usort($penyakitDetails, function($a, $b) {
            return $b['belief'] <=> $a['belief'];
        });

        return [
            'penyakit_details' => $penyakitDetails,
            'total_conflict' => $results['total_conflict'],
            'diagnosis_utama' => !empty($penyakitDetails) ? $penyakitDetails[0] : null,
            'combined_mass' => $results['combined_mass']
        ];
    }

    /**
     * Validasi hasil kombinasi evidence
     */
    public function validateCombinationResults($results)
    {
        $warnings = [];
        $errors = [];

        // Cek apakah ada belief yang valid
        $validBeliefs = array_filter($results['penyakit_beliefs'], function($belief) {
            return $belief > 0;
        });

        if (empty($validBeliefs)) {
            $warnings[] = "Tidak ada penyakit dengan belief > 0. Mungkin gejala yang dipilih tidak sesuai dengan rules yang ada.";
        }

        // Cek konflik tinggi
        if ($results['total_conflict'] > 0.8) {
            $warnings[] = "Konflik tinggi terdeteksi ({$results['total_conflict']}). Hasil diagnosis mungkin tidak akurat.";
        }

        // Cek apakah belief tertinggi terlalu rendah
        $maxBelief = max($results['penyakit_beliefs']);
        if ($maxBelief < 0.3) {
            $warnings[] = "Belief tertinggi ({$maxBelief}) terlalu rendah. Diagnosis mungkin tidak meyakinkan.";
        }

        return [
            'is_valid' => empty($errors),
            'warnings' => $warnings,
            'errors' => $errors
        ];
    }

    /**
     * Debug kombinasi evidence dengan detail proses
     */
    public function debugCombinationProcess($densitasResults)
    {
        $debugInfo = [
            'input_densitas' => $densitasResults,
            'mass_functions' => [],
            'combination_steps' => [],
            'final_results' => []
        ];

        // Hitung mass function untuk setiap GEJALA yang dipilih
        $massFunctions = [];
        foreach ($densitasResults as $gejalaId => $data) {
            $massFunction = $this->calculateMassFunctionPerGejala($gejalaId, $data['densitas']);
            $massFunctions[$gejalaId] = $massFunction;

            // Ambil informasi gejala
            $gejala = \App\Models\Gejala::find($gejalaId);
            $debugInfo['mass_functions'][$gejalaId] = [
                'gejala_nama' => $gejala ? $gejala->gejala : 'Unknown',
                'densitas' => $data['densitas'],
                'mass_function' => $massFunction,
                'penyakit_terkait' => $this->getPenyakitTerkait($gejalaId)
            ];
        }

        // Simulasi proses kombinasi step by step
        if (count($massFunctions) > 1) {
            $currentMass = null;
            $step = 1;

            foreach ($massFunctions as $gejalaId => $massFunction) {
                if ($currentMass === null) {
                    $currentMass = $massFunction;
                    $debugInfo['combination_steps']["step_{$step}"] = [
                        'description' => "Inisialisasi dengan gejala {$gejalaId}",
                        'mass_function' => $currentMass,
                        'K' => 0.0  // Tidak ada konflik pada inisialisasi
                    ];
                } else {
                    $oldMass = $currentMass;
                    $currentMass = $this->combineTwoEvidence($currentMass, $massFunction);

                    $debugInfo['combination_steps']["step_{$step}"] = [
                        'description' => "Kombinasi dengan gejala {$gejalaId}",
                        'previous_mass' => $oldMass,
                        'current_mass' => $massFunction,
                        'result_mass' => $currentMass,
                        'K' => $currentMass['K'] ?? 0.0  // K dari kombinasi ini
                    ];
                }
                $step++;
            }
        }

        // Hasil akhir
        $results = $this->combineEvidenceAccurate($densitasResults);
        $debugInfo['final_results'] = $results;

        return $debugInfo;
    }

    /**
     * Dapatkan penyakit yang terkait dengan gejala
     */
    private function getPenyakitTerkait($gejalaId)
    {
        $rules = DsRule::where('gejala_id', $gejalaId)->with(['penyakit', 'fuzzyParameter'])->get();
        $penyakitTerkait = [];

        foreach ($rules as $rule) {
            if ($rule->penyakit) {
                $penyakitTerkait[] = [
                    'id' => $rule->penyakit_id,
                    'nama' => $rule->penyakit->penyakit,
                    'keunikan' => $rule->keunikan ?? 'Sedang'
                ];
            }
        }

        return $penyakitTerkait;
    }

    /**
     * Bandingkan hasil metode lama vs baru
     */
    public function compareMethods($densitasResults)
    {
        $oldMethod = $this->combineEvidence($densitasResults);
        $newMethod = $this->combineEvidenceAccurate($densitasResults);

        $comparison = [
            'old_method' => $oldMethod,
            'new_method' => $newMethod,
            'differences' => [],
            'improvements' => []
        ];

        // Hitung perbedaan
        foreach ($oldMethod as $penyakitId => $oldBelief) {
            $newBelief = $newMethod['penyakit_beliefs'][$penyakitId] ?? 0;
            $difference = abs($newBelief - $oldBelief);

            $comparison['differences'][$penyakitId] = [
                'old_belief' => $oldBelief,
                'new_belief' => $newBelief,
                'difference' => $difference,
                'percentage_change' => $oldBelief > 0 ? (($newBelief - $oldBelief) / $oldBelief) * 100 : 0
            ];
        }

        // Analisis perbaikan
        $oldMax = max($oldMethod);
        $newMax = max($newMethod['penyakit_beliefs']);

        if ($newMax > $oldMax) {
            $comparison['improvements'][] = "Belief tertinggi meningkat dari {$oldMax} menjadi {$newMax}";
        }

        if ($newMethod['total_conflict'] > 0) {
            $comparison['improvements'][] = "Konflik terdeteksi: {$newMethod['total_conflict']} (metode lama tidak menghitung konflik)";
        }

        return $comparison;
    }

    /**
     * Hitung nilai conflict (K) untuk seluruh sistem
     */
    public function calculateTotalConflict($densitasResults)
    {
        // Dalam sistem yang disederhanakan, conflict dihitung berdasarkan variabilitas belief
        $beliefs = [];

        foreach ($densitasResults as $gejalaId => $data) {
            $rules = DsRule::where('gejala_id', $gejalaId)->get();

            foreach ($rules as $rule) {
                $densitas = $data['densitas'];
                $keunikanValues = ['Rendah' => 0.3, 'Sedang' => 0.5, 'Tinggi' => 0.8];
                $keunikanValue = $keunikanValues[$rule->keunikan] ?? 0.5;

                $belief = $densitas * $keunikanValue;
                $beliefs[] = $belief;
            }
        }

        if (count($beliefs) < 2) {
            return 0;
        }

        // Hitung standard deviation sebagai ukuran conflict
        $mean = array_sum($beliefs) / count($beliefs);
        $variance = array_sum(array_map(function($belief) use ($mean) {
            return pow($belief - $mean, 2);
        }, $beliefs)) / count($beliefs);

        return sqrt($variance);
    }
}


