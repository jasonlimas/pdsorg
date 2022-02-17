<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DivisionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // DTB
        DB::table('divisions')->insert([
            'abbreviation' => 'DTB',
            'description' => 'DTB',
        ]);

        // COR
        DB::table('divisions')->insert([
            'abbreviation' => 'COR',
            'description' => 'COR',
        ]);

        // ONL
        DB::table('divisions')->insert([
            'abbreviation' => 'ONL',
            'description' => 'ONL',
        ]);

        // RTL
        DB::table('divisions')->insert([
            'abbreviation' => 'RTL',
            'description' => 'RTL',
        ]);

        // SVC
        DB::table('divisions')->insert([
            'abbreviation' => 'SVC',
            'description' => 'SVC',
        ]);

        // SBY
        DB::table('divisions')->insert([
            'abbreviation' => 'SBY',
            'description' => 'SBY',
        ]);
    }
}
