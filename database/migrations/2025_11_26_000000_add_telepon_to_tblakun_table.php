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
        // Izinkan email menjadi nullable karena fokus login berpindah ke telepon
        if (Schema::hasColumn('tblakun', 'email')) {
            DB::statement("ALTER TABLE tblakun MODIFY email VARCHAR(255) NULL");
        }

        if (!Schema::hasColumn('tblakun', 'telepon')) {
            Schema::table('tblakun', function (Blueprint $table) {
                $table->string('telepon')->nullable()->unique()->after('email');
            });

            // Isi kolom telepon untuk data lama apabila memungkinkan
            DB::table('tblakun')
                ->whereNull('telepon')
                ->update(['telepon' => DB::raw('email')]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('tblakun', 'telepon') && $this->teleponColumnAddedByMigration()) {
            Schema::table('tblakun', function (Blueprint $table) {
                $table->dropUnique('tblakun_telepon_unique');
                $table->dropColumn('telepon');
            });
        }

        if (Schema::hasColumn('tblakun', 'email')) {
            DB::statement("ALTER TABLE tblakun MODIFY email VARCHAR(255) NOT NULL");
        }
    }
    private function teleponColumnAddedByMigration(): bool
    {
        $column = DB::select("SHOW COLUMNS FROM tblakun LIKE 'telepon'");

        if (empty($column)) {
            return false;
        }

        return strtoupper($column[0]->Null) === 'YES';
    }
};

