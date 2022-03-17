<?php

namespace App\Console;

use App\Models\Quotation;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function() {
            $quotes = Quotation::all();

            foreach ($quotes as $quote) {
                // If quote is 1 month old, mark it as expired
                if (strtotime($quote->quote_date) < strtotime('-30 days')) {
                    $quote->update([
                        'status_id' => '3' // 3 is expired
                    ]);
                }
            }
        })->daily();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
