<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call(RegionsSeeder::class);
        $this->call(DistrictsSeeder::class);
        $this->call(AdminSeeder::class);
        $this->call(OrganizationTypeSeeder::class);
        $this->call(PrescriberRolesSeeder::class);
    }
}
