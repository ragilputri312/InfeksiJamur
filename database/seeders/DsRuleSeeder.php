<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DsRule;
use App\Models\Penyakit;
use App\Models\Gejala;
use App\Models\FuzzyParameter;

class DsRuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil data penyakit dan gejala
        $penyakit = Penyakit::all()->keyBy('kode_penyakit');
        $gejala = Gejala::where('is_active', true)->get()->keyBy('kode_gejala');

        // Data relasi gejala-penyakit yang benar
        $relasiData = [
            // Lupus (P001) - 7 gejala
            ['penyakit_kode' => 'P001', 'gejala_kode' => 'G001', 'keunikan' => 'Rendah'],   // Kelelahan ekstrem
            ['penyakit_kode' => 'P001', 'gejala_kode' => 'G002', 'keunikan' => 'Sedang'],  // Nyeri dan bengkak pada sendi
            ['penyakit_kode' => 'P001', 'gejala_kode' => 'G003', 'keunikan' => 'Tinggi'],  // Ruam kulit
            ['penyakit_kode' => 'P001', 'gejala_kode' => 'G004', 'keunikan' => 'Tinggi'],  // Sariawan
            ['penyakit_kode' => 'P001', 'gejala_kode' => 'G005', 'keunikan' => 'Sedang'],  // Rambut rontok
            ['penyakit_kode' => 'P001', 'gejala_kode' => 'G006', 'keunikan' => 'Rendah'],  // Demam
            ['penyakit_kode' => 'P001', 'gejala_kode' => 'G007', 'keunikan' => 'Tinggi'],  // Fenomena Raynaud

            // Rheumatoid Arthritis (P002) - 4 gejala
            ['penyakit_kode' => 'P002', 'gejala_kode' => 'G001', 'keunikan' => 'Sedang'],  // Kelelahan ekstrem
            ['penyakit_kode' => 'P002', 'gejala_kode' => 'G002', 'keunikan' => 'Tinggi'],  // Nyeri dan bengkak pada sendi
            ['penyakit_kode' => 'P002', 'gejala_kode' => 'G006', 'keunikan' => 'Rendah'],  // Demam
            ['penyakit_kode' => 'P002', 'gejala_kode' => 'G007', 'keunikan' => 'Sedang'],  // Fenomena Raynaud

            // DM Tipe 1 (P003) - 6 gejala
            ['penyakit_kode' => 'P003', 'gejala_kode' => 'G001', 'keunikan' => 'Rendah'],  // Kelelahan ekstrem
            ['penyakit_kode' => 'P003', 'gejala_kode' => 'G008', 'keunikan' => 'Tinggi'],  // Sering buang air kecil
            ['penyakit_kode' => 'P003', 'gejala_kode' => 'G009', 'keunikan' => 'Tinggi'],  // Sering merasa haus
            ['penyakit_kode' => 'P003', 'gejala_kode' => 'G010', 'keunikan' => 'Tinggi'],  // Berat badan menurun drastis
            ['penyakit_kode' => 'P003', 'gejala_kode' => 'G011', 'keunikan' => 'Sedang'],  // Luka sulit sembuh
            ['penyakit_kode' => 'P003', 'gejala_kode' => 'G012', 'keunikan' => 'Sedang'],  // Pandangan kabur

            // Psoriasis (P004) - 5 gejala
            ['penyakit_kode' => 'P004', 'gejala_kode' => 'G013', 'keunikan' => 'Tinggi'],  // Kulit bersisik dan menebal
            ['penyakit_kode' => 'P004', 'gejala_kode' => 'G014', 'keunikan' => 'Tinggi'],  // Gatal pada kulit
            ['penyakit_kode' => 'P004', 'gejala_kode' => 'G015', 'keunikan' => 'Tinggi'],  // Kuku berubah bentuk
            ['penyakit_kode' => 'P004', 'gejala_kode' => 'G003', 'keunikan' => 'Sedang'],  // Ruam kulit
            ['penyakit_kode' => 'P004', 'gejala_kode' => 'G001', 'keunikan' => 'Rendah'],  // Kelelahan ekstrem

            // Graves Disease (P005) - 7 gejala
            ['penyakit_kode' => 'P005', 'gejala_kode' => 'G016', 'keunikan' => 'Tinggi'],  // Jantung berdebar (palpitasi)
            ['penyakit_kode' => 'P005', 'gejala_kode' => 'G017', 'keunikan' => 'Tinggi'],  // Tidak tahan panas
            ['penyakit_kode' => 'P005', 'gejala_kode' => 'G018', 'keunikan' => 'Tinggi'],  // Tangan gemetar
            ['penyakit_kode' => 'P005', 'gejala_kode' => 'G019', 'keunikan' => 'Tinggi'],  // Mata menonjol (exophthalmos)
            ['penyakit_kode' => 'P005', 'gejala_kode' => 'G020', 'keunikan' => 'Sedang'],  // Kesulitan tidur
            ['penyakit_kode' => 'P005', 'gejala_kode' => 'G010', 'keunikan' => 'Sedang'],  // Berat badan menurun drastis
            ['penyakit_kode' => 'P005', 'gejala_kode' => 'G001', 'keunikan' => 'Rendah'],  // Kelelahan ekstrem
        ];

        // Buat relasi berdasarkan data
        $createdCount = 0;
        $errorCount = 0;

        foreach ($relasiData as $relasi) {
            // Cari penyakit berdasarkan kode
            $penyakitModel = $penyakit->get($relasi['penyakit_kode']);
            // Cari gejala berdasarkan kode
            $gejalaModel = $gejala->get($relasi['gejala_kode']);

            if ($penyakitModel && $gejalaModel) {
                // Cari fuzzy parameter berdasarkan keunikan
                $fuzzyParam = FuzzyParameter::where('tipe', 'keunikan')
                    ->where('label', $relasi['keunikan'])
                    ->first();

                if ($fuzzyParam) {
                    DsRule::create([
                        'penyakit_id' => $penyakitModel->id,
                        'gejala_id' => $gejalaModel->id,
                        'fuzzy_parameter_id' => $fuzzyParam->id,
                        'deskripsi' => "Relasi {$gejalaModel->gejala} dengan {$penyakitModel->penyakit} - Keunikan: {$relasi['keunikan']}",
                        'is_active' => true,
                    ]);
                    $createdCount++;
                } else {
                    $this->command->error("Fuzzy parameter untuk keunikan '{$relasi['keunikan']}' tidak ditemukan!");
                    $errorCount++;
                }
            } else {
                $this->command->error("Penyakit '{$relasi['penyakit_kode']}' atau gejala '{$relasi['gejala_kode']}' tidak ditemukan!");
                $errorCount++;
            }
        }

        $this->command->info("Berhasil membuat {$createdCount} relasi gejala-penyakit.");
        if ($errorCount > 0) {
            $this->command->error("Terjadi {$errorCount} error saat membuat relasi.");
        }
        $this->command->info("Total relasi di database: " . DsRule::count());
    }
}
