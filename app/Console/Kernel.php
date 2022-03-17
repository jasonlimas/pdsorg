<?php

namespace App\Console;

use App\Models\Quotation;
use App\Models\TemporaryFile;
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
        // Mark old quotes as expired
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

        // Delete temporary files (attachments) and clear temporary_files table in database
        $schedule->call(function() {
            $dbEntries = TemporaryFile::all();

            foreach ($dbEntries as $entry) {
                if (file_exists(storage_path('app/attachments/tmp/' . $entry->folder))) {
                    $files = glob(storage_path('app/attachments/tmp/' . $entry->folder . '/*')); // Get all files in folder
                    foreach($files as $file) {
                        if(is_file($file))
                            unlink($file); // Delete file
                    }
                    rmdir(storage_path('app/attachments/tmp/' . $entry->folder));   // Delete folder
                }

                $entry->delete();   // Delete entry in database
            }
        })->weekly();
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
