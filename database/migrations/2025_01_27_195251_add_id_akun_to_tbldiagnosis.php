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
        Schema::table('tbldiagnosis', function (Blueprint $table) {
            if (!Schema::hasColumn('tbldiagnosis', 'id_akun')) {
                $table->unsignedBigInteger('id_akun')->nullable();
            }
        });

        // add foreign key if not exists (check information_schema)
        $fkExists = DB::table('information_schema.REFERENTIAL_CONSTRAINTS')
            ->where('CONSTRAINT_SCHEMA', DB::raw('DATABASE()'))
            ->where('TABLE_NAME', 'tbldiagnosis')
            ->where('CONSTRAINT_NAME', 'tbldiagnosis_id_akun_foreign')
            ->exists();
        if (!$fkExists) {
            Schema::table('tbldiagnosis', function (Blueprint $table) {
                $table->foreign('id_akun')->references('id_akun')->on('tblakun')->onDelete('cascade');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // drop foreign if exists
        $fkExists = DB::table('information_schema.REFERENTIAL_CONSTRAINTS')
            ->where('CONSTRAINT_SCHEMA', DB::raw('DATABASE()'))
            ->where('TABLE_NAME', 'tbldiagnosis')
            ->where('CONSTRAINT_NAME', 'tbldiagnosis_id_akun_foreign')
            ->exists();
        if ($fkExists) {
            Schema::table('tbldiagnosis', function (Blueprint $table) {
                $table->dropForeign('tbldiagnosis_id_akun_foreign');
            });
        }
        Schema::table('tbldiagnosis', function (Blueprint $table) {
            if (Schema::hasColumn('tbldiagnosis', 'id_akun')) {
                $table->dropColumn('id_akun');
            }
        });
    }
};
