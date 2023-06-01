<?php

namespace App\Console\Commands;

use App;
use App\Helpers\MailManager;
use App\User;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Log;
use Modules\EmployeeManagementModule\Entities\Partner;

class HappyBirthday extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'happy-birthday';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Happy Birthday ';

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
    public function handle(): void
    {
        $user = User::whereMonth('birthday', '=', Carbon::now()->format('m'))
            ->whereDay('birthday', '=', Carbon::now()->format('d'))
            ->where('company', '!=', 'Sisal Albania')
            ->where('company', '!=', 'TeachPitch')
            ->get();

        foreach($user as $userBirthday)
        {
            $to = $userBirthday->email;
            
            if (!empty($to)) {
                
                $from = 'info@landmark.com';

                $user = User::where("email", $to)->first();

                $view = view("email.birthday", compact('user'));

                MailManager::sendEmail($from, "Happy Birthday", $to, $view);
            } else {
                \Log::info("Nobody has birthday today");
            }
        }
        Log::info($user);
    }
}
