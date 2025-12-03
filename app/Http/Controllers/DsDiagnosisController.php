<?php

namespace App\Http\Controllers;

use App\Models\DsRule;
use App\Models\DsDiagnosis;
use App\Models\DsDiagnosisDetail;
use App\Models\Gejala;
use App\Models\Penyakit;
use App\Models\FuzzyCategory;
use App\Services\FuzzyLogicService;
use App\Services\DempsterShaferService;
use Illuminate\Http\Request;

class DsDiagnosisController extends Controller
{
    protected $fuzzyLogicService;
    protected $dempsterShaferService;

    public function __construct()
    {
        $this->fuzzyLogicService = new FuzzyLogicService();
        $this->dempsterShaferService = new DempsterShaferService();
    }
    public function index()
    {
        $gejala = Gejala::where('is_active', true)
            ->orderBy('urutan')
            ->orderBy('kode_gejala')
            ->get();

        // Get kemunculan options from fuzzy parameters (dynamic)
        $kemunculanOptions = \App\Models\FuzzyParameter::where('tipe', 'kemunculan')
            ->where('is_active', true)
            ->orderBy('urutan')
            ->get();

        return view('clients.ds_diagnosis_form_diagnosis', compact('gejala', 'kemunculanOptions'));
    }

    public function faqIndex()
    {
        $penyakit = Penyakit::orderBy('kode_penyakit')->get();
        return view('clients.ds_diagnosis_form_faq', compact('penyakit'));
    }

    public function process(Request $request)
    {
        $answers = $request->input('answers', []);
        $kemunculan = $request->input('kemunculan', []);

        if (empty($answers) || count($answers) < 2) {
            return redirect()->back()->with('error', 'Silakan jawab minimal 2 pertanyaan dengan memilih "Ya".');
        }

        // Filter only "Ya" answers for processing
        $yaAnswers = [];
        foreach ($answers as $gejalaId => $jawaban) {
            if ($jawaban === 'Ya' && isset($kemunculan[$gejalaId])) {
                $yaAnswers[$gejalaId] = [
                    'jawaban' => $jawaban,
                    'kemunculan' => $kemunculan[$gejalaId]
                ];
            }
        }

        if (count($yaAnswers) < 2) {
            return redirect()->back()->with('error', 'Silakan pilih minimal 2 gejala dengan jawaban "Ya" dan tingkat kemunculan.');
        }

        // Step 1: Hitung nilai densitas menggunakan Fuzzy Logic
        $densitasResults = $this->fuzzyLogicService->calculateAllDensitas($yaAnswers);

        if (empty($densitasResults)) {
            return redirect()->back()->with('error', 'Tidak ada gejala yang dapat diproses.');
        }

        // Step 2: Kombinasi Dempster-Shafer
        $dsResults = $this->dempsterShaferService->combineEvidenceAccurate($densitasResults);

        $penyakitBeliefs = $dsResults['penyakit_beliefs'];

        // Step 3: Ambil top 3 penyakit
        $topPenyakit = $this->dempsterShaferService->getTopPenyakit($penyakitBeliefs, 3);

        if (empty($topPenyakit)) {
            return redirect()->back()->with('error', 'Tidak dapat menentukan diagnosis. Silakan coba lagi.');
        }

        // Penyakit dengan belief tertinggi adalah diagnosis utama
        $diagnosisUtama = $topPenyakit[0];
        $maxBelief = $diagnosisUtama['belief'];

        // Calculate total conflict
        $totalConflict = $dsResults['total_conflict'] ?? 0;

        // Save diagnosis
        $diagnosis = DsDiagnosis::create([
            'user_id' => session('user_id'),
            'penyakit_id' => $diagnosisUtama['penyakit']->id,
            'belief_top' => $maxBelief,
            'conflict_k' => $totalConflict,
        ]);

        // Save diagnosis details - simpan semua gejala yang dipilih dengan nilai fuzzy
        foreach ($densitasResults as $gejalaId => $data) {
            $rule = DsRule::where('penyakit_id', $diagnosisUtama['penyakit']->id)
                          ->where('gejala_id', $gejalaId)
                          ->first();

            // Get fuzzy_parameter_id from kemunculan label
            $kemunculanFuzzyParam = \App\Models\FuzzyParameter::where('tipe', 'kemunculan')
                ->where('label', $data['kemunculan'])
                ->where('is_active', true)
                ->first();

            DsDiagnosisDetail::create([
                'ds_diagnosis_id' => $diagnosis->id,
                'gejala_id' => $gejalaId,
                'kemunculan_fuzzy_parameter_id' => $kemunculanFuzzyParam ? $kemunculanFuzzyParam->id : null,
                'fuzzy_densitas' => $data['densitas'],
                'mass_used_support' => $rule ? $data['densitas'] : 0,
                'mass_used_ignorance' => $rule ? (1 - $data['densitas']) : 0,
            ]);
        }

        return redirect()->route('ds-diagnosis.result', $diagnosis->id);
    }

    public function result($id)
    {
        $diagnosis = DsDiagnosis::with(['penyakit', 'details.gejala', 'details.kemunculanFuzzyParameter', 'user'])
            ->findOrFail($id);

        return view('clients.ds_diagnosis_result', compact('diagnosis'));
    }

    public function adminIndex()
    {
        $diagnoses = DsDiagnosis::with(['penyakit', 'user'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.ds-diagnosis.index', compact('diagnoses'));
    }

    public function adminShow($id)
    {
        $diagnosis = DsDiagnosis::with(['penyakit', 'details.gejala', 'details.kemunculanFuzzyParameter', 'user'])
            ->findOrFail($id);

        // Rekonstruksi data densitas dari diagnosis details
        $densitasResults = [];
        $fuzzyDetails = [];

        foreach ($diagnosis->details as $detail) {
            if ($detail->kemunculanFuzzyParameter && $detail->fuzzy_densitas !== null) {
                $kemunculanLabel = $detail->kemunculanFuzzyParameter->label;

                // Hitung keunikan rata-rata dari rules
                $rules = DsRule::with(['penyakit', 'fuzzyParameter'])->where('gejala_id', $detail->gejala_id)->get();
                $sum = 0.0;
                $cnt = 0;
                $penyakitKeunikan = [];

                foreach ($rules as $rule) {
                    // Get keunikan from fuzzyParameter relation or use accessor
                    $keunikanLabel = $rule->fuzzyParameter ? $rule->fuzzyParameter->label : ($rule->keunikan ?? 'Sedang');
                    $keunikanVal = \App\Models\FuzzyParameter::getNilaiByLabel('keunikan', $keunikanLabel);
                    $sum += $keunikanVal;
                    $cnt++;
                    $penyakitKeunikan[] = [
                        'penyakit_id' => $rule->penyakit_id,
                        'penyakit_nama' => $rule->penyakit ? $rule->penyakit->penyakit : 'Unknown',
                        'keunikan' => $keunikanLabel,
                        'keunikan_nilai' => $keunikanVal
                    ];
                }
                $avgKeuVal = $cnt ? $sum / $cnt : 0.5;
                $keunikanLabel = \App\Models\FuzzyParameter::getLabelByNilai('keunikan', $avgKeuVal);

                // Dapatkan nilai numerik kemunculan
                $kemVal = \App\Models\FuzzyParameter::getNilaiByLabel('kemunculan', $kemunculanLabel);

                // Simpan data untuk perhitungan DS
                $densitasResults[$detail->gejala_id] = [
                    'gejala' => $detail->gejala,
                    'kemunculan' => $kemunculanLabel,
                    'keunikan' => $keunikanLabel,
                    'densitas' => $detail->fuzzy_densitas
                ];

                // Detail perhitungan fuzzy
                $fuzzyDetails[$detail->gejala_id] = [
                    'gejala' => $detail->gejala,
                    'kemunculan_label' => $kemunculanLabel,
                    'kemunculan_nilai' => $kemVal,
                    'keunikan_label' => $keunikanLabel,
                    'keunikan_nilai' => $avgKeuVal,
                    'keunikan_detail' => $penyakitKeunikan,
                    'densitas' => $detail->fuzzy_densitas
                ];
            }
        }

        // Hitung detail Dempster-Shafer
        $dsDetails = [];
        if (!empty($densitasResults)) {
            $dsDetails = $this->dempsterShaferService->debugCombinationProcess($densitasResults);
        }

        return view('admin.ds-diagnosis.show', compact('diagnosis', 'fuzzyDetails', 'dsDetails'));
    }

    public function clientHistory()
    {
        $userId = session('user_id');

        if (!$userId) {
            return redirect()->route('user.showlogin')->with('error', 'Silakan login terlebih dahulu.');
        }

        $diagnoses = DsDiagnosis::with(['penyakit'])
            ->where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('clients.diagnosis_history', compact('diagnoses'));
    }

    public function clientHistoryDetail($id)
    {
        $userId = session('user_id');

        if (!$userId) {
            return redirect()->route('user.showlogin')->with('error', 'Silakan login terlebih dahulu.');
        }

        $diagnosis = DsDiagnosis::with(['penyakit', 'details.gejala', 'user'])
            ->where('user_id', $userId)
            ->where('id', $id)
            ->firstOrFail();

        return view('clients.ds_diagnosis_result', compact('diagnosis'));
    }

}

