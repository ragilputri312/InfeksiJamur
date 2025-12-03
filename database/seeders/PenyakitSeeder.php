<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Penyakit;

class PenyakitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $penyakits = [
            [
                'kode_penyakit' => 'P001',
                'penyakit' => 'Lupus',
                'penangan' => '1. Konsumsi obat imunosupresan seperti kortikosteroid dan hydroxychloroquine
2. Hindari paparan sinar matahari langsung
3. Gunakan tabir surya dengan SPF tinggi
4. Istirahat yang cukup dan hindari stres
5. Konsumsi makanan sehat dan bergizi
6. Rutin kontrol ke dokter spesialis reumatologi
7. Hindari aktivitas berat yang dapat memicu flare
8. Kelola stres dengan teknik relaksasi',
            ],
            [
                'kode_penyakit' => 'P002',
                'penyakit' => 'Rheumatoid Arthritis',
                'penangan' => '1. Konsumsi obat anti-inflamasi nonsteroid (NSAID)
2. Gunakan obat DMARD (Disease Modifying Anti-Rheumatic Drugs)
3. Terapi fisik dan latihan ringan secara rutin
4. Kompres hangat untuk mengurangi nyeri sendi
5. Istirahat yang cukup saat gejala memburuk
6. Gunakan alat bantu untuk mengurangi beban sendi
7. Konsumsi makanan anti-inflamasi seperti omega-3
8. Hindari merokok dan konsumsi alkohol
9. Rutin kontrol ke dokter spesialis reumatologi',
            ],
            [
                'kode_penyakit' => 'P003',
                'penyakit' => 'DM Tipe 1',
                'penangan' => '1. Injeksi insulin sesuai dosis yang ditentukan dokter
2. Monitor kadar gula darah secara rutin
3. Diet diabetes dengan kontrol karbohidrat
4. Olahraga rutin sesuai kemampuan
5. Hindari makanan tinggi gula dan karbohidrat sederhana
6. Bawa identitas pasien diabetes
7. Edukasi keluarga tentang penanganan hipoglikemia
8. Rutin kontrol ke dokter spesialis endokrinologi
9. Kelola stres untuk menjaga kadar gula darah stabil',
            ],
            [
                'kode_penyakit' => 'P004',
                'penyakit' => 'Psoriasis',
                'penangan' => '1. Gunakan pelembap kulit secara rutin
2. Konsumsi obat topikal seperti kortikosteroid
3. Terapi sinar UV pada kasus yang memerlukan
4. Hindari pemicu seperti stres, alkohol, dan merokok
5. Mandi dengan air hangat dan sabun lembut
6. Hindari menggaruk area yang terkena psoriasis
7. Konsumsi makanan sehat dan hindari makanan inflamasi
8. Kelola stres dengan teknik relaksasi
9. Rutin kontrol ke dokter spesialis kulit',
            ],
            [
                'kode_penyakit' => 'P005',
                'penyakit' => 'Graves Disease',
                'penangan' => '1. Konsumsi obat anti-tiroid seperti methimazole atau propylthiouracil
2. Hindari sumber yodium berlebih dalam makanan
3. Istirahat yang cukup dan hindari stres
4. Gunakan kacamata gelap jika mengalami fotofobia
5. Kompres dingin untuk mengatasi mata yang menonjol
6. Hindari kafein dan stimulan lainnya
7. Rutin kontrol kadar hormon tiroid
8. Pertimbangkan terapi radioaktif yodium jika diperlukan
9. Konsultasi dengan dokter spesialis endokrinologi',
            ],
        ];

        foreach ($penyakits as $penyakit) {
            Penyakit::create($penyakit);
        }

        $this->command->info('Data penyakit berhasil dibuat: ' . Penyakit::count() . ' penyakit');
    }
}
