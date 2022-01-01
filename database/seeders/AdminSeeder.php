<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admins')->insert([
            'name' => 'System Admin',
            'email' => 'admin@afyatime.com',
            'admin_type' => Admin::SYSTEM,
            'password' => Hash::make('admin')
        ]);
    }
}
