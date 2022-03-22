<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SendersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // XDC Indonesia
        DB::table('senders')->insert([
            'name' => '*DELETE ME*',
            'address' => 'KETAPANG BUSINESS CENTER BLOK D2-D3',
            'bank_info' => null,
        ]);
    }
}
