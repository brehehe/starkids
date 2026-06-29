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
        Schema::create('one_health_observation_codes', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('one_health_observation_id')->nullable();
            $table->string('coding_system')->default('http://loinc.org')->comment('Berisi satu atau lebih data dengan tipe data Coding. Nilainya mengacu pada data terminologi LOINC Codes.');
            $table->string('coding_code')->comment('Berisi satu atau lebih data dengan tipe data Coding. Nilainya mengacu pada data terminologi LOINC Codes.');
            $table->string('coding_display')->comment('Berisi satu atau lebih data dengan tipe data Coding. Nilainya mengacu pada data terminologi LOINC Codes.');
            $table->bigInteger('order')->default(0);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('one_health_observation_codes');
    }
};
