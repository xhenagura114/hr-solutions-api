<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Modules\EmployeeManagementModule\Entities\Applicant;
use Modules\EmployeeManagementModule\Entities\Partner;
use Modules\SystemSettingsModule\Entities\GeneralSettings;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct()
    {
        $system_settings = GeneralSettings::find(1);
        $user_birthdays = User::whereDay("birthday", date("d"))->whereMonth("birthday", date("m"))->count();
        $partner_birthdays = Partner::whereDay("birthday", date("d"))->whereMonth("birthday", date("m"))->count();
        $total_birthdays = $user_birthdays + $partner_birthdays;
        $users_upcoming = User::where('id', '!=', '1')->whereRaw("DATE_ADD(birthday, 
                                                INTERVAL YEAR(CURDATE())-YEAR(birthday)
                                                         + IF(DAYOFYEAR(CURDATE()) >= DAYOFYEAR(birthday),1,0)
                                                YEAR)  
                                            BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 7 DAY)")->count();
        $partners_upcoming = Partner::whereRaw("DATE_ADD(birthday, 
                                                INTERVAL YEAR(CURDATE())-YEAR(birthday)
                                                         + IF(DAYOFYEAR(CURDATE()) >= DAYOFYEAR(birthday),1,0)
                                                YEAR)  
                                            BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 7 DAY)")->count();
        $total_upcoming = $users_upcoming + $partners_upcoming;

        $total_prehired = Applicant::whereDay("quit_date", date("d"))->whereMonth("quit_date", date("m"))->count();
        $prehired_upcoming = Applicant::where('id', '!=', '1')->where('id', '!=', '1')->where('status', 'Interview Done')
            ->where('response', 'Yes')->whereRaw("DATE_ADD(quit_date, 
                                                INTERVAL YEAR(CURDATE())-YEAR(quit_date)
                                                         + IF(DAYOFYEAR(CURDATE()) >= DAYOFYEAR(quit_date),1,0)
                                                YEAR)  
                                            BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 7 DAY)")->count();

        View::share('system_settings', $system_settings);
        View::share('total_birthdays', $total_birthdays);
        View::share('total_upcoming', $total_upcoming);
        View::share('total_prehired', $total_prehired);
        View::share('prehired_upcoming', $prehired_upcoming);
    }

}
