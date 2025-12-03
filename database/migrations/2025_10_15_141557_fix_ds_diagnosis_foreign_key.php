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
        // Drop the existing foreign key constraint
        Schema::table('ds_diagnosis', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
        });

        // Add the correct foreign key constraint to tblakun table
        Schema::table('ds_diagnosis', function (Blueprint $table) {
            $table->foreign('user_id')->references('id_akun')->on('tblakun')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop the correct foreign key constraint
        Schema::table('ds_diagnosis', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
        });

        // Restore the original foreign key constraint
        Schema::table('ds_diagnosis', function (Blueprint $table) {
            if (Schema::hasTable('users')) {
                $table->foreign('user_id')->references('id')->on('users')->nullOnDelete();
            }
        });
    }
};
