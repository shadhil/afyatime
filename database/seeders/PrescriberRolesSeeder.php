<?php

namespace Database\Seeders;

use App\Models\PrescriberType;
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
        PrescriberType::create([
            [
                'title' => 'Admin',
            ],
            [
                'title' => 'Doctor',
            ],
            [
                'title' => 'Nurse'
            ],
            [
                'title' => 'Other'
            ]
        ]);
    }
}
