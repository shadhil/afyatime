<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppointmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('patient_id');
            $table->unsignedBigInteger('prescriber_id')->nullable();
            $table->unsignedBigInteger('condition_id');
            $table->enum('app_type', ['weekly', 'daily', 'hourly']);
            $table->date('date_of_visit');
            $table->time('visit_time')->default(date("08:00:00"));
            $table->unsignedBigInteger('organization_id')->nullable();
            $table->foreignId('received_by')->nullable()->constrained('prescribers')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();

            //FOREIGN KEY CONSTRAINTS
            $table->foreign('organization_id')->references('id')->on('organizations')->onUpdate('cascade')->onDelete('set null');
            $table->foreign('prescriber_id')->references('id')->on('prescribers')->onUpdate('cascade')->onDelete('set null');
            $table->foreign('patient_id')->references('id')->on('patients')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('condition_id')->references('id')->on('medical_conditions')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('appointments');
    }
}
