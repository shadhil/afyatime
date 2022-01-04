<?php

use App\Models\SubscriptionPackage;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateSubscriptionPackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subscription_packages', function (Blueprint $table) {
            $table->tinyIncrements('id');
            $table->string('name');
            $table->smallInteger('max_prescribers')->default(2);
            $table->smallInteger('reminder_msg')->default(1);
            $table->integer('monthly_appointments');
            $table->decimal('monthly_cost', 10, 2);
            $table->integer('yearly_appointments');
            $table->decimal('yearly_cost', 12, 2);
            $table->timestamps();
        });

        DB::table('subscription_packages')->insert(
            [
                [
                    'name' => 'Starter',
                    'max_prescribers' => 2,
                    'reminder_msg' => 1,
                    'monthly_appointments' => 500,
                    'monthly_cost' => 100000,
                    'yearly_appointments' => 7000,
                    'yearly_cost' => 1000000,
                ],
                [
                    'name' => 'Business',
                    'max_prescribers' => 10,
                    'reminder_msg' => 2,
                    'monthly_appointments' => 1500,
                    'monthly_cost' => 180000,
                    'yearly_appointments' => 20000,
                    'yearly_cost' => 2000000,
                ],
                [
                    'name' => 'Premium',
                    'max_prescribers' => 100,
                    'reminder_msg' => 3,
                    'monthly_appointments' => 100000,
                    'monthly_cost' => 350000,
                    'yearly_appointments' => 1000000,
                    'yearly_cost' => 5000000,
                ]
            ]
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('subscription_packages');
    }
}
