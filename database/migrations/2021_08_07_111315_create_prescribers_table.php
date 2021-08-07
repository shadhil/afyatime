<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePrescribersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prescribers', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->unsignedTinyInteger('prescriber_type')->nullable();
            $table->string('phone_number', 12);
            $table->string('email');
            $table->unsignedBigInteger('organization_id')->nullable();
            $table->timestamps();

            //FOREIGN KEY CONSTRAINTS
            $table->foreign('organization_id')->references('id')->on('organizations')->onUpdate('cascade')->onDelete('set null');
            $table->foreign('prescriber_type')->references('id')->on('prescriber_types')->onUpdate('cascade')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('prescribers');
    }
}
