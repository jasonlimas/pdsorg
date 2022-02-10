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
            'username' => 'ADMIN',
            'email' => 'admin@pdsorg.com',
            'password' => bcrypt('AdminPdsOrg!'),
            'role' => 'admin'
        ]);

        // User
        DB::table('users')->insert([
            'name' => 'USER',
            'username' => 'USER',
            'email' => 'user@mail.com',
            'password' => bcrypt('UserPdsOrg!'),
            'role' => 'sales'
        ]);
    }
}
