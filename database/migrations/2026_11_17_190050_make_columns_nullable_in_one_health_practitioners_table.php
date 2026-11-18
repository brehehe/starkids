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
        Schema::table('one_health_practitioners', function (Blueprint $table) {
            $table->string('name_use')->nullable()->change();
            $table->date('birth_date')->nullable()->comment('Berisi satu atau lebih data mengenai informasi tanggal lahir tenaga kesehatan dengan tipe data date.')->change();
            $table->string('gender')->nullable()->comment('Berisi satu atau lebih data mengenai informasi jenis kelamin tenaga kesehatan untuk keperluan administrasi dan pencatatan dengan tipe data code.')->change();
        });

        Schema::table('one_health_practitiont_addresses', function (Blueprint $table) {
            $table->string('line')->nullable()->comment('Berisi data alamat lengkap tenaga kesehatan dengan tipe data string.')->change();
            $table->string('city')->nullable()->comment('Berisi satu atau lebih data mengenai nama kota, kotamadya, pinggiran kota, desa atau komunitas lain atau pusat pengiriman dengan tipe data string.')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('one_health_practitiont_addresses', function (Blueprint $table) {
            $table->string('line')->nullable(false)->comment('Berisi data alamat lengkap tenaga kesehatan dengan tipe data string.')->change();
            $table->string('city')->nullable(false)->comment('Berisi satu atau lebih data mengenai nama kota, kotamadya, pinggiran kota, desa atau komunitas lain atau pusat pengiriman dengan tipe data string.')->change();
        });

        Schema::table('one_health_practitioners', function (Blueprint $table) {
            $table->string('name_use')->nullable(false)->change();
            $table->date('birth_date')->nullable(false)->comment('Berisi satu atau lebih data mengenai informasi tanggal lahir tenaga kesehatan dengan tipe data date.')->change();
            $table->string('gender')->nullable(false)->comment('Berisi satu atau lebih data mengenai informasi jenis kelamin tenaga kesehatan untuk keperluan administrasi dan pencatatan dengan tipe data code.')->change();
        });
    }
};
