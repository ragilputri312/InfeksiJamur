<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\FuzzyParameter;

class FuzzyParameterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear existing data using delete instead of truncate to avoid foreign key issues
        FuzzyParameter::whereNotNull('id')->delete();

        // Seed parameter kemunculan
        $kemunculanParams = [
            [
                'tipe' => 'kemunculan',
                'label' => 'Sangat Jarang',
                'nilai' => 0.2,
                'deskripsi' => 'Gejala sangat jarang muncul',
                'urutan' => 1,
                'is_active' => true
            ],
            [
                'tipe' => 'kemunculan',
                'label' => 'Kadang-Kadang',
                'nilai' => 0.5,
                'deskripsi' => 'Gejala kadang-kadang muncul',
                'urutan' => 2,
                'is_active' => true
            ],
            [
                'tipe' => 'kemunculan',
                'label' => 'Sering',
                'nilai' => 0.8,
                'deskripsi' => 'Gejala sering muncul',
                'urutan' => 3,
                'is_active' => true
            ]
        ];

        // Seed parameter keunikan
        $keunikanParams = [
            [
                'tipe' => 'keunikan',
                'label' => 'Rendah',
                'nilai' => 0.3,
                'deskripsi' => 'Gejala umum, tidak spesifik untuk penyakit tertentu',
                'urutan' => 1,
                'is_active' => true
            ],
            [
                'tipe' => 'keunikan',
                'label' => 'Sedang',
                'nilai' => 0.5,
                'deskripsi' => 'Gejala cukup spesifik untuk beberapa penyakit',
                'urutan' => 2,
                'is_active' => true
            ],
            [
                'tipe' => 'keunikan',
                'label' => 'Tinggi',
                'nilai' => 0.8,
                'deskripsi' => 'Gejala sangat spesifik dan khas untuk penyakit tertentu',
                'urutan' => 3,
                'is_active' => true
            ]
        ];

        // Insert data
        foreach ($kemunculanParams as $param) {
            FuzzyParameter::create($param);
        }

        foreach ($keunikanParams as $param) {
            FuzzyParameter::create($param);
        }

        $this->command->info('Fuzzy parameters seeded successfully!');
    }
}
