<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Penyakit;
use App\Models\NilaiCF;
use App\Models\Diagnosis;
use App\Models\TblAkun;
use App\Models\Gejala;

class DiagnosisController extends Controller
{
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'kondisi' => 'required|array',
        ]);

        // Filter array kondisi
        $filteredArray = $request->post('kondisi');
        $kondisi = array_filter($filteredArray, function ($value) {
            return $value !== null;
        });

        // Validasi apakah kondisi kosong
        if (empty($kondisi)) {
            return redirect()->back()->withErrors('Tidak ada data gejala yang dipilih');
        }

        $kodeGejala = [];
        $bobotPilihan = [];
        foreach ($kondisi as $key => $val) {
            if (is_string($val) && $val !== "#") {
                array_push($kodeGejala, $key);
                array_push($bobotPilihan, [$key, $val]);
            }
        }

        $penyakit = Penyakit::all();
        $arrGejala = [];

        foreach ($penyakit as $p) {
            $cfArr = [
                "cf" => [],
                "kode_penyakit" => []
            ];

            // Ambil data MB, MD, dan kode_gejala yang sesuai untuk setiap penyakit
            $ruleSetiapPenyakit = NilaiCF::whereIn("kode_gejala", $kodeGejala)
                ->where("kode_penyakit", $p->kode_penyakit)
                ->get();

            if ($ruleSetiapPenyakit->isNotEmpty()) {
                foreach ($ruleSetiapPenyakit as $ruleKey) {
                    // Ambil CFuser berdasarkan kode_gejala dari input kondisi
                    $cfUser = isset($kondisi[$ruleKey->kode_gejala]) ? $kondisi[$ruleKey->kode_gejala] : 0;

                    // Rumus CFcombine = MB * CFuser - MD
                    $cf = ($ruleKey->mb * $cfUser) - $ruleKey->md;

                    // Simpan hasil CF dan kode_penyakit
                    $cfArr["cf"][] = $cf;
                    $cfArr["kode_penyakit"][] = $ruleKey->kode_penyakit;
                }

                // Gabungkan CF sesuai dengan metode yang sudah didefinisikan
                $res = $this->getGabunganCf($cfArr);
                $arrGejala[] = $res;
            }
        }


        $diagnosis_id = Str::uuid()->toString();
        $id_akun = session('user_id');
        Diagnosis::create([
            'diagnosis_id' => $diagnosis_id,
            'data_diagnosis' => json_encode($arrGejala),
            'kondisi' => json_encode($bobotPilihan),
            'id_akun' => $id_akun
        ]);

        //dd($filteredArray, $kondisi, $bobotPilihan);

        return redirect()->route('diagnosis.result', ["diagnosis_id" => $diagnosis_id]);
    }

    public function getGabunganCf($cfArr)
    {
        if (empty($cfArr["cf"])) {
            return [
                "value" => "0",
                "kode_penyakit" => $cfArr["kode_penyakit"][0] ?? null
            ];
        }

        $cfoldGabungan = $cfArr["cf"][0];

        for ($i = 1; $i < count($cfArr["cf"]); $i++) {
            $cfoldGabungan = $cfoldGabungan + $cfArr["cf"][$i] * (1 - abs($cfoldGabungan));
        }

        return [
            "value" => strval($cfoldGabungan),
            "kode_penyakit" => $cfArr["kode_penyakit"][0]
        ];
    }

    public function diagnosisResult($diagnosis_id)
{
    $diagnosis = Diagnosis::where('diagnosis_id', $diagnosis_id)->first();
    $akun = Tblakun::where('id_akun', $diagnosis->id_akun)->first();

    if (!$diagnosis) {
        return redirect()->back()->withErrors('Diagnosis not found');
    }

    $gejala = json_decode($diagnosis->kondisi, true);
    $data_diagnosis = json_decode($diagnosis->data_diagnosis, true);

    if (empty($data_diagnosis)) {
        return redirect()->back()->withErrors('Data diagnosis is empty');
    }

    $int = 0.0;
    $diagnosis_dipilih = null;

    foreach ($data_diagnosis as $val) {
        if (floatval($val["value"]) > $int) {
            $penyakit = Penyakit::where("kode_penyakit", $val["kode_penyakit"])->first();
            if ($penyakit) {
                $diagnosis_dipilih = [
                    "value" => floatval($val["value"]),
                    "kode_penyakit" => $penyakit
                ];
            }
            $int = floatval($val["value"]);
        }
    }

    if (!$diagnosis_dipilih) {
        return redirect()->back()->withErrors('Penyakit not found');
    }

    // Ambil kode gejala
    $kodeGejala = array_column($gejala, 0);

    // Ambil data pakar untuk kode gejala yang ada
    $pakar = NilaiCF::whereIn("kode_gejala", $kodeGejala)
        ->where("kode_penyakit", $diagnosis_dipilih["kode_penyakit"]->kode_penyakit)
        ->get();

    // Filter gejala berdasarkan pakar
    $gejala_by_user = array_filter($gejala, function ($gKey) use ($pakar) {
        return $pakar->contains("kode_gejala", $gKey[0] ?? null);
    });

    // Tambahkan nama gejala ke dalam gejala_by_user
    foreach ($gejala_by_user as &$item) {
        $nama_gejala = Gejala::where('kode_gejala', $item[0])->first()->gejala ?? 'Unknown';
        $item[] = $nama_gejala;  // Menambahkan nama gejala
    }

    // Ambil nilai CF pakar dan user
    $nilaiPakar = $pakar->map(fn ($key) => $key->mb - $key->md)->toArray();
    $nilaiUser = array_column($gejala_by_user, 1);

    // Hitung kombinasi CF
    $cfKombinasi = $this->getCfCombinasi($nilaiPakar, $nilaiUser);
    $hasil = $this->getGabunganCf($cfKombinasi);

    // Kembalikan hasil ke view
    return view('clients.cl_diagnosa_result', [
        "akun" => $akun,
        "diagnosis" => $diagnosis,
        "diagnosis_dipilih" => $diagnosis_dipilih,
        "gejala" => $gejala,
        "data_diagnosis" => $data_diagnosis,
        "pakar" => $pakar,
        "gejala_by_user" => $gejala_by_user,  // Kirim gejala_by_user yang sudah ada nama gejalanya
        "cf_kombinasi" => $cfKombinasi,
        "hasil" => $hasil
    ]);
}


public function getCfCombinasi($pakar, $user)
{
    if (count($pakar) !== count($user)) {
        return [
            "cf" => [],
            "kode_penyakit" => [],
            "error" => "Data tidak valid"
        ];
    }

    $cfComb = [];

    for ($i = 0; $i < count($pakar); $i++) {
        $CF1 = $pakar[$i];  // Nilai CF dari pakar
        $CF2 = $user[$i];   // Nilai CF dari user

        if ($CF1 > 0 && $CF2 > 0) {
            // Kedua CF positif
            $cfComb[] = $CF1 + $CF2 * (1 - $CF1);
        } elseif ($CF1 < 0 && $CF2 < 0) {
            // Kedua CF negatif
            $cfComb[] = $CF1 + $CF2 * (1 + $CF1);
        } else {
            // Salah satu atau kedua CF berbeda tanda
            $cfComb[] = $CF1 + ($CF2 / (1 - min(abs($CF1), abs($CF2)))); // Tambahkan tanda kurung
        }
    }

    return [
        "cf" => $cfComb,
        "kode_penyakit" => ["0"]  // Placeholder untuk kode penyakit (sesuaikan jika perlu)
    ];
}


public function indexAdmin()
{
    // Join Diagnosis dengan TblAkun untuk mendapatkan nama akun
    $diagnosis = Diagnosis::join('tblakun', 'tbldiagnosis.id_akun', '=', 'tblakun.id_akun')
                          ->select('tbldiagnosis.*', 'tblakun.nama')
                          ->get();

    // Siapkan data yang diperlukan untuk tampilan
    $diagnosisData = $diagnosis->map(function ($diagnosisItem) {
        // Decode gejala (symptoms) dan data diagnosis
        $gejala = json_decode($diagnosisItem->kondisi, true);
        $data_diagnosis = json_decode($diagnosisItem->data_diagnosis, true);

        // Variabel untuk menyimpan penyakit dan persentase
        $penyakit = null;
        $persentase = 0;

        // Proses untuk mendapatkan penyakit dan persentase dari data_diagnosis
        foreach ($data_diagnosis as $val) {
            $value = floatval($val['value']);
            if ($value > $persentase) {
                $penyakitData = Penyakit::where('kode_penyakit', $val['kode_penyakit'])->first();
                if ($penyakitData) {
                    $penyakit = $penyakitData->penyakit;  // Ambil nama penyakit
                    $persentase = $value;  // Simpan persentase tertinggi
                }
            }
        }

        // Proses gejala dengan nama gejala yang sesuai
        $gejalaWithNames = [];
        foreach ($gejala as $gItem) {
            $gejalaNama = Gejala::where('kode_gejala', $gItem[0])->first()->gejala ?? 'Unknown'; // Ambil nama gejala
            $gejalaWithNames[] = [
                'kode_gejala' => $gItem[0],
                'gejala_nama' => $gejalaNama,
            ];
        }

        // Kembalikan data yang sudah diproses dalam bentuk objek
        return (object) [
            'diagnosis_id' => $diagnosisItem->diagnosis_id,
            'nama' => $diagnosisItem->nama,
            'gejala' => $gejalaWithNames,
            'penyakit' => $penyakit,
            'persentase' => number_format($persentase * 100, 2), // Menampilkan persentase dengan 2 desimal
        ];
    });

    // Kirim data yang telah diproses ke view
    return view('admin.diagnosa.hasil_diagnosa', [
        'diagnosis' => $diagnosisData,
    ]);
}

public function getDiagnosisData($diagnosis_id)
    {
        $diagnosis = Diagnosis::where('diagnosis_id', $diagnosis_id)->first();
        $akun = Tblakun::where('id_akun', $diagnosis->id_akun)->first();

        if (!$diagnosis) {
            return redirect()->back()->withErrors('Diagnosis not found');
        }

        $gejala = json_decode($diagnosis->kondisi, true);
        $data_diagnosis = json_decode($diagnosis->data_diagnosis, true);

        if (empty($data_diagnosis)) {
            return redirect()->back()->withErrors('Data diagnosis is empty');
        }

        $int = 0.0;
        $diagnosis_dipilih = null;

        foreach ($data_diagnosis as $val) {
            if (floatval($val["value"]) > $int) {
                $penyakit = Penyakit::where("kode_penyakit", $val["kode_penyakit"])->first();
                if ($penyakit) {
                    $diagnosis_dipilih = [
                        "value" => floatval($val["value"]),
                        "kode_penyakit" => $penyakit
                    ];
                }
                $int = floatval($val["value"]);
            }
        }

        if (!$diagnosis_dipilih) {
            return redirect()->back()->withErrors('Penyakit not found');
        }

        // Ambil kode gejala
        $kodeGejala = array_column($gejala, 0);

        // Ambil data pakar untuk kode gejala yang ada
        $pakar = NilaiCF::whereIn("kode_gejala", $kodeGejala)
            ->where("kode_penyakit", $diagnosis_dipilih["kode_penyakit"]->kode_penyakit)
            ->get();

        // Filter gejala berdasarkan pakar
        $gejala_by_user = array_filter($gejala, function ($gKey) use ($pakar) {
            return $pakar->contains("kode_gejala", $gKey[0] ?? null);
        });

        // Tambahkan nama gejala ke dalam gejala_by_user
        foreach ($gejala_by_user as &$item) {
            $nama_gejala = Gejala::where('kode_gejala', $item[0])->first()->gejala ?? 'Unknown';
            $item[] = $nama_gejala;  // Menambahkan nama gejala
        }

        // Ambil nilai CF pakar dan user
        $nilaiPakar = $pakar->map(fn ($key) => $key->mb - $key->md)->toArray();
        $nilaiUser = array_column($gejala_by_user, 1);

        // Hitung kombinasi CF
        $cfKombinasi = $this->getCfCombinasi($nilaiPakar, $nilaiUser);
        $hasil = $this->getGabunganCf($cfKombinasi);

        // Kembalikan hasil
        return response()->json([
            'akun' => $akun,
            'diagnosis' => $diagnosis,
            'diagnosis_dipilih' => $diagnosis_dipilih,
            'gejala' => $gejala,
            'data_diagnosis' => $data_diagnosis,
            'pakar' => $pakar,
            'gejala_by_user' => $gejala_by_user,  // Kirim gejala_by_user yang sudah ada nama gejalanya
            'cf_kombinasi' => $cfKombinasi,
            'hasil' => $hasil
        ]);

    }


}
