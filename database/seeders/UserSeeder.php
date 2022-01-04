<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'AfyaTime Admin',
            'email' => 'admin@afyatime.com',
            'account_type' => 'admin',
            'account_id' => '0',
            'is_admin' => '2',
            'status' => '2',
            'password' => Hash::make('admin')
        ]);
    }
}
