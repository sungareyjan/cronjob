<?php

namespace App\Console;

use App\Models\User;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

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
        // Task that runs at actual scheduled times (weekdays only)
        $actualTask = function () {
           try {
                User::create([
                    'name' => 'test',
                    'email' => 'test' . time() . '@example.com',
                    'password' => Hash::make('password'),
                ]);
                Log::info('Test scheduled task ran at ' . now());
            } catch (\Exception $e) {
                Log::error('Test scheduled task failed: ' . $e->getMessage());
            }
        };

        $schedule->call($actualTask)->cron('15 8 * * 1-5');  // 8:15 AM Monday-Friday
        $schedule->call($actualTask)->cron('30 13 * * 1-5'); // 1:25 PM Monday-Friday

        // Task that runs every minute for testing purposes (also weekdays only)
        $testTask = function () {
            try {
                User::create([
                    'name' => 'test',
                    'email' => 'test' . time() . '@example.com',
                    'password' => Hash::make('password'),
                ]);
                Log::info('Test scheduled task ran at ' . now());
            } catch (\Exception $e) {
                Log::error('Test scheduled task failed: ' . $e->getMessage());
            };
        };

        $schedule->call($testTask)->weekdays()->everyMinute();
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
