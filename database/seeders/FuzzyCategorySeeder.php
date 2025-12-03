<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\FuzzyCategory;

class FuzzyCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $fuzzyCategories = [
            [
                'nama_kategori' => 'Ringan',
                'min_value' => 0.00,
                'max_value' => 0.39,
                'label' => 'Ringan',
                'color' => 'info',
                'is_active' => true,
            ],
            [
                'nama_kategori' => 'Sedang',
                'min_value' => 0.40,
                'max_value' => 0.69,
                'label' => 'Sedang',
                'color' => 'warning',
                'is_active' => true,
            ],
            [
                'nama_kategori' => 'Berat',
                'min_value' => 0.70,
                'max_value' => 1.00,
                'label' => 'Berat',
                'color' => 'danger',
                'is_active' => true,
            ],
        ];

        foreach ($fuzzyCategories as $category) {
            FuzzyCategory::create($category);
        }
    }
}
