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
        Schema::create('api_outbox_tasks', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->jsonb('model_classes')->comment('Untuk menyimpan class model');
            $table->jsonb('model_ids')->comment('Untuk menyimpan id model');
            $table->string('service_class')->comment('Untuk menyimpan class service');
            $table->string('service_method')->comment('Untuk menyimpan function service');
            $table->jsonb('request_body')->nullable()->comment('menyimpan data request');
            $table->jsonb('response_body')->nullable()->comment('menyimpan data response');
            $table->enum('status', ['pending','process','success','failed'])->default('pending')->comment('status antrian api');
            $table->bigInteger('execution')->default('0')->comment('jumlah perulangan model dengan service yang sama');
            $table->dateTime('execute_at')->nullable()->comment('waktu eksekusi data api');
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
        Schema::dropIfExists('api_outbox_tasks');
    }
};
