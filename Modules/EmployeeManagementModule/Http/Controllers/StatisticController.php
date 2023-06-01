<?php

namespace Modules\EmployeeManagementModule\Http\Controllers;

use App\Http\Controllers\Controller;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Modules\CalendarModule\Entities\Event;
use Modules\EmployeeManagementModule\Entities\Applicant;
use Modules\SelfServiceModule\Entities\RequestDays;
use Modules\SystemSettingsModule\Entities\Agenda;
use Modules\SystemSettingsModule\Entities\Department;
use Modules\SystemSettingsModule\Entities\OfficialHoliday;
use Modules\SystemSettingsModule\Entities\Training;


class StatisticController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $departments = Department::withCount(["users", "requests" => function ($query) {
            $query->where("reason", "!=", "VACATION")->where("status", "APPROVED");
        }])->get();

        //BIRTHDAYS
        $users_birthdays = User::select('birthday', 'first_name', 'last_name')->where("id", "!=", 1)->get()->toArray();
        $birthdays = array_map(function ($birthday) {

            $data['title'] = $birthday['first_name'];
            $data['start'] = date("Y-") . Carbon::parse($birthday['birthday'])->format("m-d") ;
            $data['end'] = date("Y-") . Carbon::parse($birthday['birthday'])->addDay()->format("m-d");
            $data['color'] = '#FF9900';
            $data['icon'] = 'birthday-cake';

            return $data;
        }, $users_birthdays);

        //HOLIDAYS
        $official_holidays = Agenda::all()->toArray();

        $holidays = array_map(function ($holiday) {

            $data['title'] = $holiday['title'] . " (Holiday)";
            $data['start'] = date('Y') . '-' . $holiday['month'] . '-' . $holiday['day'];
            $data['end'] = Carbon::parse($data['start'])->addDay()->toDateString();
            $data['color'] = '#FF0000';

            return $data;

        }, $official_holidays);

        $calendar = array_merge($holidays, $birthdays);

        $recruitments = User::select('id', 'first_name', 'last_name', 'created_at')->where("id", "!=", 1)->orderBy('created_at', 'DESC')->limit(5)->get();

        $new_users_this_month = User::whereMonth('created_at', '=', Carbon::now()->month)->get()->count();
        $new_trainings_this_month = Training::whereMonth('created_at', '=', Carbon::now()->month)->get()->count();
        $events_this_month = Event::whereMonth('created_at', '=', Carbon::now()->month)->where('start_date', '>', Carbon::today())->get()->count();

        $applicants = Applicant::all()->count();

        return view('employeemanagementmodule::statistics.index', compact('departments', 'calendar', 'recruitments', 'new_users_this_month', 'new_trainings_this_month', 'events_this_month', 'applicants'));

    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('employeemanagementmodule::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function show()
    {
        return view('employeemanagementmodule::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit()
    {
        return view('employeemanagementmodule::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(Request $request)
    {
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy()
    {
    }

    public function getUsersRequestsByDepartment($id)
    {
        $requests = DB::table('requests')
            ->where('requests.department_id', $id)
            ->leftJoin('departments', 'departments.id', '=', 'requests.department_id')
            ->select('requests.*', 'departments.color as color')
            ->where('requests.status', 'APPROVED')
            ->get()->toArray();


        $response = array_map(function ($request) {

            $user = User::findOrFail($request->user_id);

            $data['id'] = $request->id;
            $data['title'] = $user->first_name . ' ' . $user->last_name . " ($request->reason)";
            $data['start'] = $request->start_date;
            $data['end'] = Carbon::parse($request->end_date)->addDay()->toDateString();
            $data['color'] = $request->color;

            return $data;

        }, $requests);

        return $response;
    }

    public function getBirthdayHoliday(Request $request)
    {

        if ($request->input('type') == 'birthday') {

            $users_birthdays = User::select('birthday', 'first_name', 'last_name')->where("id", "!=", 1)->get()->toArray();
            $birthdays = array_map(function ($birthday) {

                $data['title'] = $birthday['first_name'] . ' ' . $birthday['last_name'];
                $data['start'] = date("Y-") . Carbon::parse($birthday['birthday'])->format("m-d") ;
                $data['end'] = date("Y-") . Carbon::parse($birthday['birthday'])->addDay()->format("m-d");
                $data['color'] = '#FF9900';

                return $data;
            }, $users_birthdays);
            return $birthdays;

        } else {

            $official_holidays = OfficialHoliday::all()->toArray();

            $holidays = array_map(function ($holiday) {

                $data['title'] = $holiday['title'];
                $data['start'] = date('Y') . '-' . $holiday['month'] . '-' . $holiday['day'];
                $data['end'] = Carbon::parse($data['start'])->addDay()->toDateString();
                $data['color'] = '#FF0000';

                return $data;

            }, $official_holidays);

            return $holidays;

        }
    }

}
