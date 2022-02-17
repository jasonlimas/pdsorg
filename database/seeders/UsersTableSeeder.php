<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Admin
        DB::table('users')->insert([
            'name' => 'ADMIN',
            'email' => 'admin@mail.com',
            'password' => bcrypt('AdminPdsOrg!'),
            'role_id' => 1,
            'phone' => '040000000',
            'sender_id' => 0,
        ]);

        // Team Leader
        DB::table('users')->insert([
            'name' => 'LEADER',
            'email' => 'leader@mail.com',
            'password' => bcrypt('LeaderPdsOrg!'),
            'role_id' => 2,
            'sender_id' => 0,
            'phone' => '0411111111',
        ]);

        // Sales Person
        DB::table('users')->insert([
            'name' => 'SALES',
            'email' => 'sales@mail.com',
            'password' => bcrypt('SalesPdsOrg!'),
            'role_id' => 3,
            'sender_id' => 0,
            'phone' => '0422222222',
        ]);
    }
}
