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
        // Step 1: Add new column fuzzy_parameter_id
        Schema::table('ds_rules', function (Blueprint $table) {
            $table->unsignedBigInteger('fuzzy_parameter_id')->nullable()->after('gejala_id');
        });

        // Step 2: Migrate existing keunikan data to fuzzy_parameter_id
        $dsRules = DB::table('ds_rules')->get();

        foreach ($dsRules as $rule) {
            if ($rule->keunikan) {
                // Find the corresponding fuzzy parameter
                $fuzzyParam = DB::table('fuzzy_parameters')
                    ->where('tipe', 'keunikan')
                    ->where('label', $rule->keunikan)
                    ->where('is_active', true)
                    ->first();

                if ($fuzzyParam) {
                    DB::table('ds_rules')
                        ->where('id', $rule->id)
                        ->update(['fuzzy_parameter_id' => $fuzzyParam->id]);
                }
            }
        }

        // Step 3: Drop the old keunikan column and its index
        Schema::table('ds_rules', function (Blueprint $table) {
            $table->dropIndex('idx_ds_rules_keunikan');
            $table->dropColumn('keunikan');
        });

        // Step 4: Make fuzzy_parameter_id NOT NULL and add foreign key
        Schema::table('ds_rules', function (Blueprint $table) {
            $table->unsignedBigInteger('fuzzy_parameter_id')->nullable(false)->change();
            $table->foreign('fuzzy_parameter_id')
                ->references('id')
                ->on('fuzzy_parameters')
                ->onDelete('restrict')
                ->onUpdate('cascade');

            $table->index('fuzzy_parameter_id', 'idx_ds_rules_fuzzy_parameter_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Step 1: Add back keunikan column
        Schema::table('ds_rules', function (Blueprint $table) {
            $table->string('keunikan', 50)->nullable()->after('gejala_id');
        });

        // Step 2: Migrate fuzzy_parameter_id back to keunikan
        $dsRules = DB::table('ds_rules')->get();

        foreach ($dsRules as $rule) {
            if ($rule->fuzzy_parameter_id) {
                $fuzzyParam = DB::table('fuzzy_parameters')
                    ->where('id', $rule->fuzzy_parameter_id)
                    ->first();

                if ($fuzzyParam) {
                    DB::table('ds_rules')
                        ->where('id', $rule->id)
                        ->update(['keunikan' => $fuzzyParam->label]);
                }
            }
        }

        // Step 3: Drop foreign key and fuzzy_parameter_id column
        Schema::table('ds_rules', function (Blueprint $table) {
            $table->dropForeign(['fuzzy_parameter_id']);
            $table->dropIndex('idx_ds_rules_fuzzy_parameter_id');
            $table->dropColumn('fuzzy_parameter_id');
        });

        // Step 4: Make keunikan NOT NULL and add index
        Schema::table('ds_rules', function (Blueprint $table) {
            $table->string('keunikan', 50)->nullable(false)->default('Sedang')->change();
            $table->index('keunikan', 'idx_ds_rules_keunikan');
        });
    }
};
