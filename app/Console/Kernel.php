<?php

namespace App\Console;

use App\Models\User;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
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

        $task = function () {
            User::create([
                'name'              => 'name',
                'email'             => 'user'.time().'@example.com',
                'email_verified_at' =>  now(),
                'password'          => Hash::make('password'),
                'created_at'        => now(),
                'updated_at'        => now(),
            ]);
            Log::info('Data inserted by scheduled task.');
        };

        $schedule->call($task)->weekdays()->cron('15 8 * * 1-9');
        $schedule->call($task)->weekdays()->cron('30 13 * * 1-9');
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
