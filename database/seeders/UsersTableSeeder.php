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
        DB::table('users')->insert([
            'name' => 'ADMIN',
            'username' => 'ADMIN',
            'email' => 'admin@pdsorg.com',
            'password' => bcrypt('AdminPdsOrg!'),
            'role' => 'admin'
        ]);
    }
}
