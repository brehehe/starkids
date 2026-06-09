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
        Schema::create('one_health_observation_value_quantities', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('one_health_observation_id')->nullable()->comment('Berisi data hasil observasi berupa numerik dengan satuan dengan tipe data Quantity.');
            $table->string('system')->default('http://unitsofmeasure.org')->comment('Berisi data hasil observasi berupa numerik dengan satuan dengan tipe data Quantity.');
            $table->bigInteger('value')->comment('Berisi data hasil observasi berupa numerik dengan satuan dengan tipe data Quantity.');
            $table->string('code')->comment('Berisi data hasil observasi berupa numerik dengan satuan dengan tipe data Quantity.');
            $table->string('unit')->comment('Berisi data hasil observasi berupa numerik dengan satuan dengan tipe data Quantity.');
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
        Schema::dropIfExists('one_health_observation_value_quantities');
    }
};
