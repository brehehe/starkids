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
        Schema::create('one_health_observations', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('observation_id')->nullable();
            $table->string('id_observation')->nullable();
            $table->foreignUuid('one_health_organization_id')->nullable();
            $table->foreignUuid('one_health_practitioner_id')->nullable();
            $table->foreignUuid('one_health_patient_id')->nullable();
            $table->foreignUuid('one_health_encounter_id')->nullable();
            $table->string('status')->comment('Berisi data mengenai status dari hasil observasi dengan tipe data code yang nilainya mengacu pada data terminologi ObservationStatus.');
            $table->string('subject_reference')->default('Patient/')->comment('Berisi data pasien yang memiliki hasil observasi dengan tipe data Reference, yang direferensikan ke data yang tersimpan di resource Patient | Group | Device | Location');
            $table->string('performer_reference')->default('Practitioner/')->comment('Berisi data siapa yang bertanggung jawab untuk menyatakan nilai observasi sebagai "benar" dengan tipe data Reference, yang direferensikan ke data yang tersimpan di resource Practitioner | PractitionerRole | Organization | CareTeam | Patient | RelatedPerson');
            $table->string('encounter_reference')->default('Encounter/')->comment('Berisi data kunjungan di mana hasil observasi didapatkan dengan tipe data Reference, yang direferensikan ke data yang tersimpan di resource Encounter');
            $table->dateTime('effective_date_time')->nullable()->comment('Berisi data mengenai kapan observasi dilakukan');
            $table->dateTime('issued')->nullable()->comment('Berisi data tanggal dan waktu versi observasi ini tersedia, biasanya setelah hasilnya ditinjau/direview dan diverifikasi');
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
        Schema::dropIfExists('one_health_observations');
    }
};
