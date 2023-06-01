<?php

namespace App\Console\Commands;

use App\Task;
use Artisan;
use Illuminate\Console\Command;

class RunEmailTask extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'run-email-task';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $tasks = Task::where("status", '0')->get();
        foreach ($tasks as $task){
            $command = $task->command;
            $from = $task->from;
            $to = $task->to;
            $type = $task->type;

            Artisan::call($command, [
                'from' => $from,
                'to' => $to,
                'type' => $type,
            ]);

            $task->delete();

            \Log::info("success runned");
        }
    }
}
