<?php

namespace Database\Seeders;

use App\Models\SubscriptionPackage;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SubscriptionPackage::create(
            [
                [
                    'name' => 'Starter',
                    'max_prescribers' => 2,
                    'app_reminders' => 1,
                    'monthly_appointments' => 150,
                    'monthly_cost' => 150000,
                ],
                [
                    'name' => 'Business',
                    'max_prescribers' => 10,
                    'app_reminders' => 2,
                    'monthly_appointments' => 250,
                    'monthly_cost' => 300000,
                ],
                [
                    'name' => 'Premium',
                    'max_prescribers' => 100,
                    'app_reminders' => 3,
                    'monthly_appointments' => 1000,
                    'monthly_cost' => 500000,
                ]
            ]
        );
    }
}
