<?php

namespace App\Http\Controllers;

use App\Task;
use App\User;
use Artisan;
use Carbon\Carbon;
use Illuminate\Http\Response;
use Modules\CalendarModule\Entities\Event;
use Modules\EmployeeManagementModule\Entities\Applicant;
use Modules\SystemSettingsModule\Entities\Department;
use Modules\SystemSettingsModule\Entities\JobVacancy;
use Modules\SystemSettingsModule\Entities\Training;
use DB;



use Illuminate\Console\Command;

class DashboardController extends Controller
{
    public function newEmployees()
    {
        $new_employees = User::whereMonth('created_at', '=', Carbon::now()->month)->get()->count();

        return response()->json([
            'Number of new employees this month' => $new_employees
        ]);
    }

    public function newApplicants()
    {
        $new_applicants = Applicant::all()->count();

        return response()->json([
            'Number of new applicants' => $new_applicants
        ]);
    }

    public function newEvents()
    {
        $new_events = Event::where('start_date', '>', Carbon::now())->orderBy('start_date', 'ASC')->limit(3)->get();

        return response()->json([
            'Number of upcoming events this month' => $new_events
        ]);
    }

    public function jobVacancies()
    {
        $job_vacancies = JobVacancy::selectRaw("position, count(*) as number")->orderBy("position")->groupBy("position")->havingRaw("count(position) > 0")->get();

        return response()->json([
            'New job vacancies in company' => $job_vacancies
        ]);
    }

    public function usersDepartments()
    {
        $departments = Department::withCount(["users", "requests" => function ($query) {
            $query->where("reason", "!=", "VACATION")->where("status", "APPROVED");
        }])->get();

        return response()->json([
            'Numer of users in each department' => $departments
        ]);
    }

    public function organigram()
    {
        $departments_name = Department::all();

        return response()->json([
            'Departments in company' => $departments_name
        ]);
    }

    public function recruitment()
    {
        $users_recruitment = User::whereMonth('created_at', '=', Carbon::now()->month)->latest()->take(5)->get();

        return response()->json([
            'Latest users hired in company' => $users_recruitment
        ]);
    }
}