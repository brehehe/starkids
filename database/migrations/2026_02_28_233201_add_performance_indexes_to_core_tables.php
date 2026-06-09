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
        // 1. Indexing untuk referensi silang identitas dan peran Pasien / Karyawan
        Schema::table('user_company_roles', function (Blueprint $table) {
            $table->index('company_id');
            $table->index('role_id');
            $table->index('user_id');
            $table->index('medical_record_number');
        });

        // 2. Indexing untuk kecepatan pencarian LIKE String pada data basis user global
        Schema::table('users', function (Blueprint $table) {
            $table->index('name');
            $table->index('phone');
        });

        // 3. Indexing pada Dokter
        Schema::table('doctors', function (Blueprint $table) {
            $table->index('company_id');
            $table->index('type'); // type old/new/dsb sering diakses di kondisi Pos Sale Admin
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('doctors', function (Blueprint $table) {
            $table->dropIndex(['company_id']);
            $table->dropIndex(['type']);
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex(['name']);
            $table->dropIndex(['phone']);
        });

        Schema::table('user_company_roles', function (Blueprint $table) {
            $table->dropIndex(['company_id']);
            $table->dropIndex(['role_id']);
            $table->dropIndex(['user_id']);
            $table->dropIndex(['medical_record_number']);
        });
    }
};
