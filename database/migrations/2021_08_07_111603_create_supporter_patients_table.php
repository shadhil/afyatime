<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSupporterPatientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('supporter_patients', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('supporter_id');
            $table->unsignedBigInteger('patient_id');
            $table->timestamps();

            //FOREIGN KEY CONSTRAINTS
            $table->foreign('supporter_id')->references('id')->on('treatment_supporters')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('patient_id')->references('id')->on('patients')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('supporter_patients');
    }
}
