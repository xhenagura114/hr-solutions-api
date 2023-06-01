<?php

namespace App\Http\Controllers;

use App\Helpers\MailManager;
use App\Task;
use App\User;
use Artisan;
use Carbon\Carbon;
use Modules\CalendarModule\Entities\Event;
use Modules\EmployeeManagementModule\Entities\Applicant;
use Modules\SystemSettingsModule\Entities\Department;
use Modules\SystemSettingsModule\Entities\JobVacancy;
use Modules\SystemSettingsModule\Entities\Training;
use Modules\EmployeeManagementModule\Entities\Partner;
use DB;



use Illuminate\Console\Command;



class HomeController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $departments = Department::withCount(["users", "requests" => function ($query) {
            $query->where("reason", "!=", "VACATION")->where("status", "APPROVED");
        }])->get();

        $new_users_this_month = User::whereMonth('created_at', '=', Carbon::now()->month)->get()->count();
        $total_trainings = Training::get()->count();
        $upcoming_trainings = Training::whereDate('start_date', '>', Carbon::today()->toDateString())->get()->count();
        $old_trainings = Training::whereDate('end_date', '<', Carbon::today()->toDateString())->get()->count();
        $trainings_now = Training::whereDate('start_date', '<=', Carbon::today()->toDateString())->whereDate('end_date', '>=', Carbon::today()->toDateString())->get()->count();

        $events_this_month = Event::whereMonth('created_at', '=', Carbon::now()->month)->where('start_date', '>', Carbon::today())->get()->count();

        $departments_name = Department::all();
        $upcoming_events = Event::where('start_date', '>', Carbon::now())->orderBy('start_date', 'ASC')->limit(3)->get();

        $user_educations = User::whereNotNull('education')->groupBy('education')->select('education', DB::raw('count(*) as total'))->get();
       // $traningsWithDepartments = Department::withCount('trainings')->get();
        $applicants = Applicant::all()->count();

        $job_vacancies = JobVacancy::selectRaw("position, count(*) as number")->orderBy("position")->groupBy("position")->havingRaw("count(position) > 0")->get();

        return view('dashboard', compact('departments', 'new_users_this_month', 'total_trainings', 'upcoming_trainings', 'old_trainings', 'trainings_now', 'events_this_month', 'departments_name', 'upcoming_events', 'user_educations', 'applicants'));
    }


    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function countBirthdays()
    {
        $users = User::whereDay("birthday", date("d"))->whereMonth("birthday", date("m"))->count();

        return response()->json([
            "success" => true,
            "data" => $users,
            "message" => "Success"
        ], 200);
    }


    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function listBirthdays()
    {
        $users = User::where('id', '!=', '1')->whereDay("birthday", date("d"))->whereMonth("birthday", date("m"))->get();
        $partners = Partner::whereDay("birthday", date("d"))->whereMonth("birthday", date("m"))->get();

        $users_upcoming = User::with(['jobs', 'departments'])->where('id', '!=', '1')->whereRaw("DATE_ADD(birthday, 
                                                INTERVAL YEAR(CURDATE())-YEAR(birthday)
                                                         + IF(DAYOFYEAR(CURDATE()) >= DAYOFYEAR(birthday),1,0)
                                                YEAR)  
                                            BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 7 DAY)")->get();
        $partners_upcoming = Partner::whereRaw("DATE_ADD(birthday, 
                                                INTERVAL YEAR(CURDATE())-YEAR(birthday)
                                                         + IF(DAYOFYEAR(CURDATE()) >= DAYOFYEAR(birthday),1,0)
                                                YEAR)  
                                            BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 7 DAY)")->get();
        return view('birthdays.index', compact('users', 'partners', 'users_upcoming', 'partners_upcoming'));
    }


    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function makeWish($type, $id)
    {
        if ($type == 'partner')
            $user = Partner::findOrFail($id);
        else
            $user = User::findOrFail($id);

        $currentUser = \Sentinel::getUser();

        Task::create([
            "from" => $currentUser->email,
            "to" => $user->email,
            "command" => "happy-birthday",
            "status" => "0",
            "type" => $type
        ]);


        $view = view("email.birthday", compact('user'));

        MailManager::sendEmail($currentUser->email, "Happy Birthday", $user->email, $view);

        \Log::info($currentUser->email. " : this user is wished");

        return redirect()->back()->with(["message" => "Successfully wished"]);
    }
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function login()
    {
        return view('auth.login');
    }

    public function countPreHired()
    {
        $users = Applicant::whereDay("quit_date", date("d"))->whereMonth("quit_date", date("m"))->count();

        return response()->json([
            "success" => true,
            "data" => $users,
            "message" => "Success"
        ], 200);
    }

    public function listPreHired()
    {
        $users = Applicant::where('id', '!=', '1')->whereDay("quit_date", date("d"))->whereMonth("quit_date", date("m"))->get();

        $applicant_upcoming = Applicant::with([ 'jobVacancies'])->where('id', '!=', '1')->where('status', 'Interview Done')
                                ->where('response', 'Yes')->whereRaw("DATE_ADD(quit_date, 
                                                INTERVAL YEAR(CURDATE())-YEAR(quit_date)
                                                         + IF(DAYOFYEAR(CURDATE()) >= DAYOFYEAR(quit_date),1,0)
                                                YEAR)  
                                            BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 7 DAY)")->get();

      return view('employeemanagementmodule::pre-hired.notification', compact('users', 'applicant_upcoming'));
    }

}
