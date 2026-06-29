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
        Schema::create('one_health_observation_categories', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('one_health_observation_id')->nullable();
            $table->string('coding_system')->default('http://terminology.hl7.org/CodeSystem/observation-category')->comment('Berisi data mengenai status dari hasil observasi dengan tipe data code yang nilainya mengacu pada data terminologi ObservationStatus.');
            $table->string('coding_code')->comment('Berisi data mengenai status dari hasil observasi dengan tipe data code yang nilainya mengacu pada data terminologi ObservationStatus.');
            $table->string('coding_display')->comment('Berisi data mengenai status dari hasil observasi dengan tipe data code yang nilainya mengacu pada data terminologi ObservationStatus.');
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
        Schema::dropIfExists('one_health_observation_categories');
    }
};
