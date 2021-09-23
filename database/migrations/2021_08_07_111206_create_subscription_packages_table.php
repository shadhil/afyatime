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
            $table->tinyInteger('reminder_msg')->default(1);
            $table->smallInteger('monthly_appointments')->default(150);
            $table->decimal('monthly_cost');
            $table->timestamps();
        });

        DB::table('subscription_packages')->insert(
            [
                [
                    'name' => 'Starter',
                    'max_prescribers' => 2,
                    'reminder_msg' => 1,
                    'monthly_appointments' => 150,
                    'monthly_cost' => 150000,
                ],
                [
                    'name' => 'Business',
                    'max_prescribers' => 10,
                    'reminder_msg' => 2,
                    'monthly_appointments' => 250,
                    'monthly_cost' => 300000,
                ],
                [
                    'name' => 'Premium',
                    'max_prescribers' => 100,
                    'reminder_msg' => 3,
                    'monthly_appointments' => 1000,
                    'monthly_cost' => 500000,
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
