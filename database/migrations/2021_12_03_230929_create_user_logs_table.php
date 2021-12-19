<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedTinyInteger('user_action_id')->nullable();
            $table->foreignId('prescriber_id')->constrained('prescribers')->nullable();
            $table->morphs('entity');
            $table->string('note')->nullable();
            $table->timestamps();
            $table->softDeletes();

            //FOREIGN KEY CONSTRAINTS
            $table->foreign('user_action_id')->references('id')->on('user_actions')->onUpdate('cascade')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_logs');
    }
}
