<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class QuoteStatusesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Not sent
        DB::table('quote_statuses')->insert([
            'name' => 'Not sent',
        ]);

        // Sent to client
        DB::table('quote_statuses')->insert([
            'name' => 'Sent',
        ]);

        // Expired
        DB::table('quote_statuses')->insert([
            'name' => 'Expired',
        ]);
    }
}
