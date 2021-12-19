<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrganizationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('organizations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('logo')->nullable();
            $table->string('phone_number', 20);
            $table->string('email');
            $table->unsignedTinyInteger('organization_type');
            $table->string('location');
            $table->unsignedTinyInteger('district_id')->nullable();
            $table->timestamps();

            //FOREIGN KEY CONSTRAINTS
            $table->foreign('district_id')->references('id')->on('districts')->onUpdate('cascade')->onDelete('set null');
            $table->foreign('organization_type')->references('id')->on('organization_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('organizations');
    }
}
