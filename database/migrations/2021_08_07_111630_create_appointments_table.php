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
            $table->date('date_of_visit');
            $table->time('time_from')->default(date("08:00:00"));
            $table->time('time_to')->nullable();
            $table->unsignedBigInteger('organization_id')->nullable();
            $table->timestamps();

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
