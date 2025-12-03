<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('ds_rules', function (Blueprint $table) {
            // Drop mass support and mass ignorance columns
            $table->dropColumn(['mass_support', 'mass_ignorance']);

            // Add description column for better documentation
            $table->text('deskripsi')->nullable()->after('gejala_id');

            // Add is_active column to enable/disable rules
            $table->boolean('is_active')->default(true)->after('deskripsi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ds_rules', function (Blueprint $table) {
            // Restore mass support and mass ignorance columns
            $table->decimal('mass_support', 5, 4)->after('gejala_id');
            $table->decimal('mass_ignorance', 5, 4)->after('mass_support');

            // Drop new columns
            $table->dropColumn(['deskripsi', 'is_active']);
        });
    }
};
