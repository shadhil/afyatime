<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PrescriberRolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('prescriber_types')->insert(
            array(
                0 =>
                array(
                    'title' => 'Doctor',
                    'initial' => 'Dr.',
                ),
                1 =>
                array(
                    'title' => 'Nurse',
                    'initial' => NULL,
                ),
            )
        );
    }
}
