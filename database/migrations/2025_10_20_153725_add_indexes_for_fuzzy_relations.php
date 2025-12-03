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
            // Add index on keunikan column for better query performance
            $table->index('keunikan', 'idx_ds_rules_keunikan');
        });

        Schema::table('fuzzy_parameters', function (Blueprint $table) {
            // Add unique index on tipe and label combination
            // This ensures no duplicate labels for the same type
            $table->unique(['tipe', 'label'], 'idx_fuzzy_params_tipe_label');
        });

        Schema::table('ds_diagnosis_details', function (Blueprint $table) {
            // Check if kemunculan column exists, if not create it
            if (!Schema::hasColumn('ds_diagnosis_details', 'kemunculan')) {
                $table->string('kemunculan', 50)->nullable()->after('gejala_id');
            }

            // Add index on kemunculan column
            if (Schema::hasColumn('ds_diagnosis_details', 'kemunculan')) {
                $table->index('kemunculan', 'idx_ds_diagnosis_details_kemunculan');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ds_rules', function (Blueprint $table) {
            $table->dropIndex('idx_ds_rules_keunikan');
        });

        Schema::table('fuzzy_parameters', function (Blueprint $table) {
            $table->dropUnique('idx_fuzzy_params_tipe_label');
        });

        Schema::table('ds_diagnosis_details', function (Blueprint $table) {
            if (Schema::hasColumn('ds_diagnosis_details', 'kemunculan')) {
                $table->dropIndex('idx_ds_diagnosis_details_kemunculan');
            }
        });
    }
};
