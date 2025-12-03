<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Carbon;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // ensure role admin exists (id_role = 1)
        $role = DB::table('tblrole')->where('id_role', 1)->first();
        if (!$role) {
            DB::table('tblrole')->insert([
                'id_role' => 1,
                'nama' => 'admin',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // upsert admin akun
        DB::table('tblakun')->updateOrInsert(
            ['telepon' => '081100000000'],
            [
                'nama' => 'Administrator',
                'email' => null,
                'telepon' => '081100000000',
                'sandi' => Hash::make('admin123'),
                'alamat' => 'System',
                'jk' => 'L',
                'id_role' => 1,
                'updated_at' => now(),
                'created_at' => DB::raw('COALESCE(created_at, NOW())')
            ]
        );
    }
}
