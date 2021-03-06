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
            'sender_id' => 1,
            'division_id' => 1,
            'name_abbreviation' => 'ADM'
        ]);

        // Team Leader
        DB::table('users')->insert([
            'name' => 'LEADER',
            'email' => 'leader@mail.com',
            'password' => bcrypt('LeaderPdsOrg!'),
            'role_id' => 2,
            'sender_id' => 1,
            'phone' => '0411111111',
            'division_id' => 1,
            'name_abbreviation' => 'LDR'
        ]);

        // Sales Person
        DB::table('users')->insert([
            'name' => 'SALES',
            'email' => 'sales@mail.com',
            'password' => bcrypt('SalesPdsOrg!'),
            'role_id' => 3,
            'sender_id' => 1,
            'phone' => '0422222222',
            'division_id' => 1,
            'name_abbreviation' => 'SAL'
        ]);
    }
}
