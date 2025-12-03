<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Tambahkan kolom keunikan ke tabel ds_rules jika belum ada
        if (!Schema::hasColumn('ds_rules', 'keunikan')) {
            Schema::table('ds_rules', function (Blueprint $table) {
                $table->enum('keunikan', ['Rendah', 'Sedang', 'Tinggi'])->default('Sedang')->after('gejala_id');
            });
        }

        // Migrasi data keunikan dari tblgejala ke ds_rules
        $dsRules = DB::table('ds_rules')->get();

        foreach ($dsRules as $rule) {
            $gejala = DB::table('tblgejala')->where('id', $rule->gejala_id)->first();
            if ($gejala && isset($gejala->keunikan)) {
                DB::table('ds_rules')
                    ->where('id', $rule->id)
                    ->update(['keunikan' => $gejala->keunikan]);
            }
        }

        // Hapus kolom keunikan dari tabel tblgejala jika ada
        if (Schema::hasColumn('tblgejala', 'keunikan')) {
            Schema::table('tblgejala', function (Blueprint $table) {
                $table->dropColumn('keunikan');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Tambahkan kembali kolom keunikan ke tabel tblgejala
        Schema::table('tblgejala', function (Blueprint $table) {
            $table->enum('keunikan', ['Rendah', 'Sedang', 'Tinggi'])->default('Sedang')->after('pertanyaan');
        });

        // Migrasi data keunikan kembali dari ds_rules ke tblgejala
        $dsRules = DB::table('ds_rules')->get();

        foreach ($dsRules as $rule) {
            if ($rule->keunikan) {
                DB::table('tblgejala')
                    ->where('id', $rule->gejala_id)
                    ->update(['keunikan' => $rule->keunikan]);
            }
        }

        // Hapus kolom keunikan dari tabel ds_rules
        Schema::table('ds_rules', function (Blueprint $table) {
            $table->dropColumn('keunikan');
        });
    }
};
