<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppointmentsLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appointments_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedTinyInteger('app_action_id')->nullable();
            $table->foreignId('appointment_id')->constrained('appointments')->nullable();
            $table->foreignId('prescriber_id')->constrained('prescribers')->nullable();
            $table->timestamps();
            $table->softDeletes();

            //FOREIGN KEY CONSTRAINTS
            $table->foreign('app_action_id')->references('id')->on('app_actions')->onUpdate('cascade')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('appointments_logs');
    }
}
