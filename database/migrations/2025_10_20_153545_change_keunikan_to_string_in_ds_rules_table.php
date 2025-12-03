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
        // Change keunikan column from ENUM to VARCHAR for dynamic fuzzy parameters
        DB::statement("ALTER TABLE `ds_rules` MODIFY `keunikan` VARCHAR(50) NOT NULL DEFAULT 'Sedang'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert keunikan column back to ENUM
        DB::statement("ALTER TABLE `ds_rules` MODIFY `keunikan` ENUM('Rendah', 'Sedang', 'Tinggi') NOT NULL DEFAULT 'Sedang'");
    }
};
