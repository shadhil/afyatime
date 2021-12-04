<?php

use App\Models\AppAction;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppActionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('app_actions', function (Blueprint $table) {
            $table->tinyIncrements('id');
            $table->string('action');
        });

        AppAction::insert([
            [
                'action' => 'created',
            ],
            [
                'action' => 'updated',
            ],
            [
                'action' => 'deleted',
            ],
            [
                'action' => 'received',
            ]
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('app_actions');
    }
}
