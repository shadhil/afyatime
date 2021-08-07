<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTreatmentSupportersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('treatment_supporters', function (Blueprint $table) {
            $table->id();
            $table->string('full_name');
            $table->string('phone_number');
            $table->string('email')->nullable();
            $table->string('location');
            $table->unsignedTinyInteger('district_id')->nullable();
            $table->unsignedBigInteger('organization_id')->nullable();
            $table->timestamps();

            //FOREIGN KEY CONSTRAINTS
            $table->foreign('organization_id')->references('id')->on('organizations')->onUpdate('cascade')->onDelete('set null');
            $table->foreign('district_id')->references('id')->on('districts')->onUpdate('cascade')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('treatment_supporters');
    }
}
