<?php

namespace App\Services;

use App\Models\Gejala;
use App\Models\DsRule;
use App\Models\FuzzyParameter;

class FuzzyLogicService
{
    /**
     * Hitung nilai densitas menggunakan metode Tsukamoto
     *
     * @param string $kemunculan Kemunculan gejala (Sangat Jarang, Kadang-Kadang, Sering)
     * @param string $keunikan Keunikan gejala (Rendah, Sedang, Tinggi)
     * @return float Nilai densitas antara 0-1
     */

    public function calculateDensitasNumeric(float $kemunculanVal, float $keunikanVal): float
    {
        $rules = $this->getFuzzyRules();
        $totalWeight = 0.0;
        $totalValue  = 0.0;

        foreach ($rules as $rule) {
            $kemunculanMembership = $this->calculateMembership($kemunculanVal, $rule['kemunculan']);
            $keunikanMembership   = $this->calculateMembership($keunikanVal, $rule['keunikan']);
            $w = min($kemunculanMembership, $keunikanMembership);

            $totalWeight += $w;
            $totalValue  += $w * $rule['output'];
        }
        return $totalWeight > 0 ? $totalValue / $totalWeight : 0.5;
    }


    /**
     * Aturan fuzzy untuk sistem
     */
    private function getFuzzyRules()
    {
        return [
            // IF Kemunculan = Sering AND Keunikan = Tinggi THEN Densitas = Sangat Tinggi
            ['kemunculan' => ['min' => 0.7, 'max' => 1.0], 'keunikan' => ['min' => 0.7, 'max' => 1.0], 'output' => 0.9],

            // IF Kemunculan = Sering AND Keunikan = Sedang THEN Densitas = Tinggi
            ['kemunculan' => ['min' => 0.7, 'max' => 1.0], 'keunikan' => ['min' => 0.4, 'max' => 0.6], 'output' => 0.8],

            // IF Kemunculan = Sering AND Keunikan = Rendah THEN Densitas = Sedang
            ['kemunculan' => ['min' => 0.7, 'max' => 1.0], 'keunikan' => ['min' => 0.0, 'max' => 0.3], 'output' => 0.6],

            // IF Kemunculan = Kadang AND Keunikan = Tinggi THEN Densitas = Tinggi
            ['kemunculan' => ['min' => 0.4, 'max' => 0.6], 'keunikan' => ['min' => 0.7, 'max' => 1.0], 'output' => 0.7],

            // IF Kemunculan = Kadang AND Keunikan = Sedang THEN Densitas = Sedang
            ['kemunculan' => ['min' => 0.4, 'max' => 0.6], 'keunikan' => ['min' => 0.4, 'max' => 0.6], 'output' => 0.5],

            // IF Kemunculan = Kadang AND Keunikan = Rendah THEN Densitas = Rendah
            ['kemunculan' => ['min' => 0.4, 'max' => 0.6], 'keunikan' => ['min' => 0.0, 'max' => 0.3], 'output' => 0.3],

            // IF Kemunculan = Sangat Jarang AND Keunikan = Tinggi THEN Densitas = Sedang
            ['kemunculan' => ['min' => 0.0, 'max' => 0.3], 'keunikan' => ['min' => 0.7, 'max' => 1.0], 'output' => 0.4],

            // IF Kemunculan = Sangat Jarang AND Keunikan = Sedang THEN Densitas = Rendah
            ['kemunculan' => ['min' => 0.0, 'max' => 0.3], 'keunikan' => ['min' => 0.4, 'max' => 0.6], 'output' => 0.2],

            // IF Kemunculan = Sangat Jarang AND Keunikan = Rendah THEN Densitas = Sangat Rendah
            ['kemunculan' => ['min' => 0.0, 'max' => 0.3], 'keunikan' => ['min' => 0.0, 'max' => 0.3], 'output' => 0.1],
        ];
    }

    /**
     * Hitung derajat keanggotaan untuk nilai tertentu
     */
    private function calculateMembership($value, $range)
    {
        if ($value >= $range['min'] && $value <= $range['max']) {
            return 1.0;
        }

        // Linear interpolation untuk nilai di luar range
        if ($value < $range['min']) {
            $distance = $range['min'] - $value;
            return max(0, 1 - $distance / 0.3); // 0.3 adalah lebar range
        } else {
            $distance = $value - $range['max'];
            return max(0, 1 - $distance / 0.3);
        }
    }

    /**
     * Hitung nilai densitas untuk semua gejala yang dipilih
     *
     * @param array $selectedSymptoms Array gejala yang dipilih dengan kemunculan
     * @return array Array dengan id gejala dan nilai densitas
     */

    public function calculateAllDensitas($selectedSymptoms)
    {
        $results = [];

        foreach ($selectedSymptoms as $gejalaId => $data) {
            if ($data['jawaban'] !== 'Ya') continue;

            // 1) numeric kemunculan
            $kemVal = FuzzyParameter::getNilaiByLabel('kemunculan', $data['kemunculan']);

            // 2) avg keunikan numerik
            $rules = DsRule::where('gejala_id', $gejalaId)->get();
            $sum = 0.0; $cnt = 0;
            foreach ($rules as $r) {
                $sum += FuzzyParameter::getNilaiByLabel('keunikan', $r->keunikan);
                $cnt++;
            }
            $avgKeuVal = $cnt ? $sum / $cnt : 0.5;

            // (opsional) label hanya untuk ditampilkan
            $keunikanLabel = FuzzyParameter::getLabelByNilai('keunikan', $avgKeuVal);

            // 3) hitung Tsukamoto dengan nilai numerik
            $dens = $this->calculateDensitasNumeric($kemVal, $avgKeuVal);

            $results[$gejalaId] = [
                'gejala'     => Gejala::find($gejalaId),
                'kemunculan' => $data['kemunculan'],   // label untuk UI
                'keunikan'   => $keunikanLabel,        // label untuk UI
                'densitas'   => $dens,                 // hasil numerik kontinu
            ];
        }
        return $results;
    }

}
