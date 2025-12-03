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
        // Step 1: Add new column kemunculan_fuzzy_parameter_id
        Schema::table('ds_diagnosis_details', function (Blueprint $table) {
            $table->unsignedBigInteger('kemunculan_fuzzy_parameter_id')->nullable()->after('gejala_id');
        });

        // Step 2: Migrate existing kemunculan data to kemunculan_fuzzy_parameter_id
        $diagnosisDetails = DB::table('ds_diagnosis_details')->get();

        foreach ($diagnosisDetails as $detail) {
            if ($detail->kemunculan) {
                // Find the corresponding fuzzy parameter
                $fuzzyParam = DB::table('fuzzy_parameters')
                    ->where('tipe', 'kemunculan')
                    ->where('label', $detail->kemunculan)
                    ->where('is_active', true)
                    ->first();

                if ($fuzzyParam) {
                    DB::table('ds_diagnosis_details')
                        ->where('id', $detail->id)
                        ->update(['kemunculan_fuzzy_parameter_id' => $fuzzyParam->id]);
                }
            }
        }

        // Step 3: Drop the old kemunculan column and its index if exists
        Schema::table('ds_diagnosis_details', function (Blueprint $table) {
            // Check if index exists before dropping
            if (Schema::hasColumn('ds_diagnosis_details', 'kemunculan')) {
                try {
                    $table->dropIndex('idx_ds_diagnosis_details_kemunculan');
                } catch (\Exception $e) {
                    // Index might not exist, continue
                }
                $table->dropColumn('kemunculan');
            }
        });

        // Step 4: Make kemunculan_fuzzy_parameter_id NOT NULL and add foreign key
        Schema::table('ds_diagnosis_details', function (Blueprint $table) {
            $table->unsignedBigInteger('kemunculan_fuzzy_parameter_id')->nullable(false)->change();
            $table->foreign('kemunculan_fuzzy_parameter_id', 'fk_dd_kemunculan_fp')
                ->references('id')
                ->on('fuzzy_parameters')
                ->onDelete('restrict')
                ->onUpdate('cascade');

            $table->index('kemunculan_fuzzy_parameter_id', 'idx_dd_kemunculan_fp_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Step 1: Add back kemunculan column
        Schema::table('ds_diagnosis_details', function (Blueprint $table) {
            $table->string('kemunculan', 50)->nullable()->after('gejala_id');
        });

        // Step 2: Migrate kemunculan_fuzzy_parameter_id back to kemunculan
        $diagnosisDetails = DB::table('ds_diagnosis_details')->get();

        foreach ($diagnosisDetails as $detail) {
            if ($detail->kemunculan_fuzzy_parameter_id) {
                $fuzzyParam = DB::table('fuzzy_parameters')
                    ->where('id', $detail->kemunculan_fuzzy_parameter_id)
                    ->first();

                if ($fuzzyParam) {
                    DB::table('ds_diagnosis_details')
                        ->where('id', $detail->id)
                        ->update(['kemunculan' => $fuzzyParam->label]);
                }
            }
        }

        // Step 3: Drop foreign key and kemunculan_fuzzy_parameter_id column
        Schema::table('ds_diagnosis_details', function (Blueprint $table) {
            $table->dropForeign('fk_dd_kemunculan_fp');
            $table->dropIndex('idx_dd_kemunculan_fp_id');
            $table->dropColumn('kemunculan_fuzzy_parameter_id');
        });

        // Step 4: Add index to kemunculan
        Schema::table('ds_diagnosis_details', function (Blueprint $table) {
            $table->index('kemunculan', 'idx_ds_diagnosis_details_kemunculan');
        });
    }
};
