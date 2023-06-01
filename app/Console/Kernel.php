<?php

namespace App\Console;
use App\Console\Commands\HappyBirthday;
use App\Console\Commands\RunEmailTask;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\DB;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        Commands\HappyBirthday::class,
        Commands\RunEmailTask::class,
        Commands\transferSkills::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('run-email-task')
            ->everyMinute()->appendOutputTo(storage_path().'/logs/laravel_output.log');

        $schedule->command('happy-birthday')
            ->cron('10 14 * * *')->timezone('Europe/Tirane')->appendOutputTo(storage_path().'/logs/laravel_output.log');

        $schedule->command('transfer:skills --force')->everyTenMinutes()->appendOutputTo(storage_path().'/logs/laravel_output.log');
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
