<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Gejala;

class GejalaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $gejalas = [
            [
                'kode_gejala' => 'G001',
                'gejala' => 'Kelelahan ekstrem',
                'pertanyaan' => 'Apakah Anda mengalami kelelahan yang berlebihan?',
                'urutan' => 1,
                'is_active' => true,
            ],
            [
                'kode_gejala' => 'G002',
                'gejala' => 'Nyeri dan bengkak pada sendi',
                'pertanyaan' => 'Apakah Anda mengalami nyeri dan bengkak pada sendi?',
                'urutan' => 2,
                'is_active' => true,
            ],
            [
                'kode_gejala' => 'G003',
                'gejala' => 'Ruam kulit',
                'pertanyaan' => 'Apakah Anda mengalami ruam pada kulit?',
                'urutan' => 3,
                'is_active' => true,
            ],
            [
                'kode_gejala' => 'G004',
                'gejala' => 'Sariawan',
                'pertanyaan' => 'Apakah Anda mengalami sariawan di mulut?',
                'urutan' => 4,
                'is_active' => true,
            ],
            [
                'kode_gejala' => 'G005',
                'gejala' => 'Rambut rontok',
                'pertanyaan' => 'Apakah Anda mengalami rambut rontok yang berlebihan?',
                'urutan' => 5,
                'is_active' => true,
            ],
            [
                'kode_gejala' => 'G006',
                'gejala' => 'Demam',
                'pertanyaan' => 'Apakah Anda mengalami demam?',
                'urutan' => 6,
                'is_active' => true,
            ],
            [
                'kode_gejala' => 'G007',
                'gejala' => 'Fenomena Raynaud',
                'pertanyaan' => 'Apakah jari-jari Anda berubah warna saat kedinginan?',
                'urutan' => 7,
                'is_active' => true,
            ],
            [
                'kode_gejala' => 'G008',
                'gejala' => 'Sering buang air kecil',
                'pertanyaan' => 'Apakah Anda sering buang air kecil?',
                'urutan' => 8,
                'is_active' => true,
            ],
            [
                'kode_gejala' => 'G009',
                'gejala' => 'Sering merasa haus',
                'pertanyaan' => 'Apakah Anda sering merasa haus?',
                'urutan' => 9,
                'is_active' => true,
            ],
            [
                'kode_gejala' => 'G010',
                'gejala' => 'Berat badan menurun drastis',
                'pertanyaan' => 'Apakah berat badan Anda menurun drastis?',
                'urutan' => 10,
                'is_active' => true,
            ],
            [
                'kode_gejala' => 'G011',
                'gejala' => 'Luka sulit sembuh',
                'pertanyaan' => 'Apakah luka Anda sulit sembuh?',
                'urutan' => 11,
                'is_active' => true,
            ],
            [
                'kode_gejala' => 'G012',
                'gejala' => 'Pandangan kabur',
                'pertanyaan' => 'Apakah pandangan Anda terasa kabur?',
                'urutan' => 12,
                'is_active' => true,
            ],
            [
                'kode_gejala' => 'G013',
                'gejala' => 'Kulit bersisik dan menebal',
                'pertanyaan' => 'Apakah kulit Anda bersisik dan menebal?',
                'urutan' => 13,
                'is_active' => true,
            ],
            [
                'kode_gejala' => 'G014',
                'gejala' => 'Gatal pada kulit',
                'pertanyaan' => 'Apakah kulit Anda terasa gatal?',
                'urutan' => 14,
                'is_active' => true,
            ],
            [
                'kode_gejala' => 'G015',
                'gejala' => 'Kuku berubah bentuk',
                'pertanyaan' => 'Apakah kuku Anda berubah bentuk?',
                'urutan' => 15,
                'is_active' => true,
            ],
            [
                'kode_gejala' => 'G016',
                'gejala' => 'Jantung berdebar (palpitasi)',
                'pertanyaan' => 'Apakah jantung Anda sering berdebar?',
                'urutan' => 16,
                'is_active' => true,
            ],
            [
                'kode_gejala' => 'G017',
                'gejala' => 'Tidak tahan panas',
                'pertanyaan' => 'Apakah Anda tidak tahan dengan suhu panas?',
                'urutan' => 17,
                'is_active' => true,
            ],
            [
                'kode_gejala' => 'G018',
                'gejala' => 'Tangan gemetar',
                'pertanyaan' => 'Apakah tangan Anda sering gemetar?',
                'urutan' => 18,
                'is_active' => true,
            ],
            [
                'kode_gejala' => 'G019',
                'gejala' => 'Mata menonjol (exophthalmos)',
                'pertanyaan' => 'Apakah mata Anda terlihat menonjol?',
                'urutan' => 19,
                'is_active' => true,
            ],
            [
                'kode_gejala' => 'G020',
                'gejala' => 'Kesulitan tidur',
                'pertanyaan' => 'Apakah Anda mengalami kesulitan tidur?',
                'urutan' => 20,
                'is_active' => true,
            ],
        ];

        foreach ($gejalas as $gejala) {
            Gejala::create($gejala);
        }

        $this->command->info('Data gejala berhasil dibuat: ' . Gejala::count() . ' gejala');
    }
}
