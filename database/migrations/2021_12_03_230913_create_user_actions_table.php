<?php

use App\Models\UserAction;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserActionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_actions', function (Blueprint $table) {
            $table->tinyIncrements('id');
            $table->string('action');
        });

        UserAction::insert([
            [
                'action' => 'Signed In',
            ],
            [
                'action' => 'Signed Out',
            ],
            [
                'action' => 'Create Patient',
            ],
            [
                'action' => 'Update Patient',
            ],
            [
                'action' => 'Delete Patient',
            ],
            [
                'action' => 'Create Supporter',
            ],
            [
                'action' => 'Update Supporter',
            ],
            [
                'action' => 'Delete Supporter',
            ],
            [
                'action' => 'Create Prescriber',
            ],
            [
                'action' => 'Update Prescriber',
            ],
            [
                'action' => 'Delete Prescriber',
            ],
            [
                'action' => 'Create Appointment',
            ],
            [
                'action' => 'Update Appointment',
            ],
            [
                'action' => 'Delete Appointment',
            ],
            [
                'action' => 'Confirmed Appointment',
            ],
            [
                'action' => 'Failed Appointment',
            ],
            [
                'action' => 'Update Role/Title',
            ],
            [
                'action' => 'Assign Supporter',
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
        Schema::dropIfExists('user_actions');
    }
}
