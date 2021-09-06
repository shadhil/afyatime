<?php

namespace Database\Seeders;

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
        DB::table('subscription_packages')->insert([
            [
                'name' => 'Package A',
                'max_patients' => '50',
                'monthly_cost' => '300000'
            ],
            [
                'name' => 'Package B',
                'max_patients' => '100',
                'monthly_cost' => '500000'
            ],
            [
                'name' => 'Package C',
                'max_patients' => '1000',
                'monthly_cost' => '1000000'
            ]
        ]);
    }
}
