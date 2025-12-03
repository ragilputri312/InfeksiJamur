<?php

namespace App\Http\Controllers;

use App\Models\FuzzyParameter;
use App\Services\FuzzyLogicService;
use Illuminate\Http\Request;

class FuzzyRuleController extends Controller
{
    protected $fuzzyLogicService;

    public function __construct()
    {
        $this->fuzzyLogicService = new FuzzyLogicService();
    }

    /**
     * Display fuzzy rules management page
     */
    public function index()
    {
        // Get dynamic parameters from database
        $kemunculanParams = FuzzyParameter::getKemunculanOptions();
        $keunikanParams = FuzzyParameter::getKeunikanOptions();

        // Generate fuzzy rules dynamically based on parameters
        $fuzzyRules = [];
        $ruleId = 1;

        foreach ($kemunculanParams as $kemunculan) {
            foreach ($keunikanParams as $keunikan) {
                // Calculate output using the actual fuzzy logic service
                $output = $this->fuzzyLogicService->calculateDensitas($kemunculan->label, $keunikan->label);

                $fuzzyRules[] = [
                    'id' => $ruleId++,
                    'kemunculan' => $kemunculan->label,
                    'kemunculan_nilai' => $kemunculan->nilai,
                    'keunikan' => $keunikan->label,
                    'keunikan_nilai' => $keunikan->nilai,
                    'output' => $output,
                    'description' => "IF Kemunculan = {$kemunculan->label} AND Keunikan = {$keunikan->label} THEN Densitas = " . $this->getOutputLabel($output)
                ];
            }
        }

        return view('admin.fuzzy-rules.index', compact('fuzzyRules', 'kemunculanParams', 'keunikanParams'));
    }

    /**
     * Get output label based on value
     */
    private function getOutputLabel($value)
    {
        if ($value >= 0.8) return 'Sangat Tinggi';
        if ($value >= 0.6) return 'Tinggi';
        if ($value >= 0.4) return 'Sedang';
        if ($value >= 0.2) return 'Rendah';
        return 'Sangat Rendah';
    }

    /**
     * Show fuzzy logic explanation
     */
    public function explanation()
    {
        // Get current parameters from database
        $kemunculanParams = FuzzyParameter::getKemunculanOptions();
        $keunikanParams = FuzzyParameter::getKeunikanOptions();

        // Build dynamic parameter strings
        $kemunculanString = $kemunculanParams->map(function($param) {
            return "{$param->label} ({$param->nilai})";
        })->join(', ');

        $keunikanString = $keunikanParams->map(function($param) {
            return "{$param->label} ({$param->nilai})";
        })->join(', ');

        $explanation = [
            'title' => 'Penjelasan Logika Fuzzy dalam Sistem Diagnosis',
            'sections' => [
                [
                    'title' => 'Input Fuzzy (Dinamis)',
                    'content' => 'Sistem menggunakan dua input fuzzy yang dapat dikonfigurasi:',
                    'items' => [
                        "Kemunculan: {$kemunculanString}",
                        "Keunikan: {$keunikanString}",
                        "Nilai-nilai ini dapat diubah melalui menu Parameter Fuzzy"
                    ]
                ],
                [
                    'title' => 'Metode Tsukamoto',
                    'content' => 'Metode Tsukamoto digunakan untuk menghasilkan nilai crisp dari aturan fuzzy:',
                    'items' => [
                        'Menghitung derajat keanggotaan untuk setiap input',
                        'Menggunakan operator AND (minimum) untuk menggabungkan kondisi',
                        'Menghasilkan nilai output yang crisp berdasarkan aturan'
                    ]
                ],
                [
                    'title' => 'Aturan Fuzzy',
                    'content' => 'Sistem menggunakan 9 aturan fuzzy yang mencakup semua kombinasi input:',
                    'items' => [
                        'Setiap aturan memiliki output densitas antara 0-1',
                        'Output yang lebih tinggi menunjukkan gejala yang lebih signifikan',
                        'Aturan dapat disesuaikan sesuai kebutuhan domain'
                    ]
                ],
                [
                    'title' => 'Integrasi dengan Dempster-Shafer',
                    'content' => 'Nilai densitas fuzzy digunakan sebagai input untuk Dempster-Shafer:',
                    'items' => [
                        'Densitas fuzzy mempengaruhi mass function',
                        'Kombinasi evidence menggunakan rumus Dempster-Shafer',
                        'Hasil akhir adalah nilai belief untuk setiap penyakit'
                    ]
                ]
            ]
        ];

        return view('admin.fuzzy-rules.explanation', compact('explanation'));
    }
}
