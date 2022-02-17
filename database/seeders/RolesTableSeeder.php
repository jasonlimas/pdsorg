<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Admin
        DB::table('roles')->insert([
            'name' => 'Admin',
        ]);

        // Team Leader
        DB::table('roles')->insert([
            'name' => 'Team Leader',
        ]);

        // Sales Person
        DB::table('roles')->insert([
            'name' => 'Sales',
        ]);
    }
}
