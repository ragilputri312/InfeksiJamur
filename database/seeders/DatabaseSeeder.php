<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // panggil semua seeder
        $this->call([
            AdminSeeder::class,
            FuzzyCategorySeeder::class,
            FuzzyParameterSeeder::class,
            PenyakitSeeder::class,
            GejalaSeeder::class,
            DsRuleSeeder::class,
        ]);
    }
}
