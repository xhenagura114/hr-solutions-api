<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Modules\CalendarModule\Entities\EventType;

class dummy extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dummy:event-type';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fill Event types table with dummy data';

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
        EventType::insert([
            [
                'type' => 'Business',
                'color' => '#FF0000'
            ],
            [
                'type' => 'Internal',
                'color' => '#0000FF'
            ],
            [
                'type' => 'Party',
                'color' => '#00FF00'
            ]
        ]);

    }
}
