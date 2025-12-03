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
        Schema::table('tblgejala', function (Blueprint $table) {
            if (!Schema::hasColumn('tblgejala', 'pertanyaan')) {
                $table->string('pertanyaan', 255)->nullable()->after('gejala');
            }
            if (!Schema::hasColumn('tblgejala', 'is_active')) {
                $table->boolean('is_active')->default(true)->after('pertanyaan');
            }
            if (!Schema::hasColumn('tblgejala', 'urutan')) {
                $table->integer('urutan')->nullable()->after('is_active');
            }
        });

        // ensure unique index for kode_gejala if not exists
        if (Schema::hasColumn('tblgejala', 'kode_gejala')) {
            $exists = DB::table('information_schema.STATISTICS')
                ->where('TABLE_SCHEMA', DB::raw('DATABASE()'))
                ->where('TABLE_NAME', 'tblgejala')
                ->where('INDEX_NAME', 'tblgejala_kode_gejala_unique')
                ->exists();
            if (!$exists) {
                Schema::table('tblgejala', function (Blueprint $table) {
                    $table->unique('kode_gejala', 'tblgejala_kode_gejala_unique');
                });
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // drop columns if exist
        Schema::table('tblgejala', function (Blueprint $table) {
            if (Schema::hasColumn('tblgejala', 'pertanyaan')) {
                $table->dropColumn('pertanyaan');
            }
            if (Schema::hasColumn('tblgejala', 'is_active')) {
                $table->dropColumn('is_active');
            }
            if (Schema::hasColumn('tblgejala', 'urutan')) {
                $table->dropColumn('urutan');
            }
        });
        // drop unique index if exists
        $exists = DB::table('information_schema.STATISTICS')
            ->where('TABLE_SCHEMA', DB::raw('DATABASE()'))
            ->where('TABLE_NAME', 'tblgejala')
            ->where('INDEX_NAME', 'tblgejala_kode_gejala_unique')
            ->exists();
        if ($exists) {
            try {
                Schema::table('tblgejala', function (Blueprint $table) {
                    $table->dropUnique('tblgejala_kode_gejala_unique');
                });
            } catch (\Throwable $e) {
                // ignore if cannot drop
            }
        }
    }
};
