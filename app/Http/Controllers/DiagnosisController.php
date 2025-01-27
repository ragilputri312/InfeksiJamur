<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use App\Models\Penyakit;
use App\Models\NilaiCF;
use App\Models\Diagnosis;

class DiagnosisController extends Controller
{
    public function store(Request $request)
    {
        $filteredArray = $request->post('kondisi');
        $kondisi = array_filter($filteredArray, function ($value) {
            return $value !== null;
        });

        $kodeGejala = [];
        $bobotPilihan = [];
        foreach ($kondisi as $key => $val) {
            if ($val != "#") {
                echo "key : $key, val : $val";
                echo "<br>";
                array_push($kodeGejala, $key);
                array_push($bobotPilihan, array($key, $val));
            }
        }

        $penyakit = Penyakit::all();
        $cf = 0;
        // penyakit
        $arrGejala = [];
        for ($i = 0; $i < count($penyakit); $i++) {
            $cfArr = [
                "cf" => [],
                "kode_penyakit" => []
            ];
            $res = 0;
            $ruleSetiapPenyakit = NilaiCF::whereIn("kode_gejala", $kodeGejala)->where("kode_penyakit", $penyakit[$i]->kode_penyakit)->get();
            if (count($ruleSetiapPenyakit) > 0) {
                foreach ($ruleSetiapPenyakit as $ruleKey) {
                    $cf = $ruleKey->mb - $ruleKey->md;
                    array_push($cfArr["cf"], $cf);
                    array_push($cfArr["kode_penyakit"], $ruleKey->kode_penyakit);
                }
                $res = $this->getGabunganCf($cfArr);
                array_push($arrGejala, $res);
            } else {
                continue;
            }
        }

        $diagnosis_id = uniqid();
        $ins =  Diagnosis::create([
            'diagnosis_id' => strval($diagnosis_id),
            'data_diagnosis' => json_encode($arrGejala),
            'kondisi' => json_encode($bobotPilihan)
        ]);
        return redirect()->route('diagnosis.result', ["diagnosis_id" => $diagnosis_id]);
    }

    public function getGabunganCf($cfArr)
    {
        if (!$cfArr["cf"]) {
            return 0;
        }
        if (count($cfArr["cf"]) == 1) {
            return [
                "value" => strval($cfArr["cf"][0]),
                "kode_penyakit" => $cfArr["kode_penyakit"][0]
            ];
        }

        $cfoldGabungan = $cfArr["cf"][0];

        for ($i = 0; $i < count($cfArr["cf"]) - 1; $i++) {
            $cfoldGabungan = $cfoldGabungan + ($cfArr["cf"][$i + 1] * (1 - $cfoldGabungan));
        }


        return [
            "value" => "$cfoldGabungan",
            "kode_penyakit" => $cfArr["kode_penyakit"][0]
        ];
    }

    public function diagnosisResult($diagnosis_id)
{
    // Ambil data diagnosis berdasarkan diagnosis_id
    $diagnosis = Diagnosis::where('diagnosis_id', $diagnosis_id)->first();

    // Jika data diagnosis tidak ditemukan
    if (!$diagnosis) {
        return redirect()->back()->withErrors('Diagnosis not found');
    }

    // Dekode data gejala dan data diagnosis
    $gejala = json_decode($diagnosis->kondisi, true);
    $data_diagnosis = json_decode($diagnosis->data_diagnosis, true);

    // Jika data diagnosis kosong
    if (empty($data_diagnosis)) {
        return redirect()->back()->withErrors('Data diagnosis is empty');
    }

    $int = 0.0;
    $diagnosis_dipilih = [];

    // Menentukan diagnosis yang paling cocok berdasarkan nilai tertinggi
    foreach ($data_diagnosis as $val) {
        if (floatval($val["value"]) > $int) {
            $diagnosis_dipilih["value"] = floatval($val["value"]);
            // Pastikan penyakit ditemukan
            $penyakit = Penyakit::where("kode_penyakit", $val["kode_penyakit"])->first();
            if ($penyakit) {
                $diagnosis_dipilih["kode_penyakit"] = $penyakit;
            } else {
                $diagnosis_dipilih["kode_penyakit"] = null; // Jika tidak ditemukan
            }
            $int = floatval($val["value"]);
        }
    }

    // Ambil kode gejala dari data gejala
    $kodeGejala = [];
    foreach ($gejala as $key) {
        array_push($kodeGejala, $key[0]);
    }

    // Pastikan kode penyakit dipilih ada
    $kode_penyakit = $diagnosis_dipilih["kode_penyakit"] ? $diagnosis_dipilih["kode_penyakit"]->kode_penyakit : null;

    if (!$kode_penyakit) {
        return redirect()->back()->withErrors('Penyakit not found');
    }

    // Ambil data pakar berdasarkan kode gejala dan kode penyakit
    $pakar = NilaiCF::whereIn("kode_gejala", $kodeGejala)->where("kode_penyakit", $kode_penyakit)->get();

    // Ambil gejala yang dipilih oleh user berdasarkan data pakar
    $gejala_by_user = [];
    foreach ($pakar as $key) {
        foreach ($gejala as $gKey) {
            if (isset($gKey[0]) && $gKey[0] == $key->kode_gejala) {
                array_push($gejala_by_user, $gKey);
            }
        }
    }

    // Hitung nilai kombinasi dari pakar dan user
    $nilaiPakar = [];
    foreach ($pakar as $key) {
        array_push($nilaiPakar, ($key->mb - $key->md));
    }

    $nilaiUser = [];
    foreach ($gejala_by_user as $key) {
        array_push($nilaiUser, $key[1]);
    }

    // Hitung CF kombinasi dan gabungan
    $cfKombinasi = $this->getCfCombinasi($nilaiPakar, $nilaiUser);
    $hasil = $this->getGabunganCf($cfKombinasi);

    //dd($diagnosis_dipilih, $pakar, $gejala_by_user);

    // Return data ke view
    return view('clients.cl_diagnosa_result', [
        "diagnosis" => $diagnosis,
        "diagnosis_dipilih" => $diagnosis_dipilih,
        "gejala" => $gejala,
        "data_diagnosis" => $data_diagnosis,
        "pakar" => $pakar,
        "gejala_by_user" => $gejala_by_user,
        "cf_kombinasi" => $cfKombinasi,
        "hasil" => $hasil
    ]);
}


    public function getCfCombinasi($pakar, $user)
    {
        $cfComb = [];
        if (count($pakar) == count($user)) {
            for ($i = 0; $i < count($pakar); $i++) {
                $res = $pakar[$i] * $user[$i];
                array_push($cfComb, floatval($res));
            }
            return [
                "cf" => $cfComb,
                "kode_penyakit" => ["0"]
            ];
        } else {
            return "Data tidak valid";
        }
    }
}
