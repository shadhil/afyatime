<?php

namespace Database\Seeders;

use App\Models\OrganizationType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrganizationTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('organization_types')->insert(
            array(
                0 =>
                array(
                    'type' => 'Hospital',
                ),
                1 =>
                array(
                    'type' => 'NGOs',
                ),
                2 =>
                array(
                    'type' => 'Clinic',
                ),
            )
        );
    }
}
