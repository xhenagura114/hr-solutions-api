<?php

namespace Modules\SelfServiceModule\Http\Controllers;

use App\User;
use Sentinel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * Include core controller to share global variables if needed
 *
 * Krisid Misso
 */

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Modules\SelfServiceModule\Entities\RequestDays;
use Modules\SystemSettingsModule\Entities\Department;
use Modules\SystemSettingsModule\Entities\OfficialHoliday;

class SelfServiceModuleController extends Controller
{
    /**
     * ALL REQUESTS
     * Display a listing of the resource.
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application|Response|\Illuminate\View\View
     */
    public function index()
    {
//        $user = Sentinel::getUser();
        $requests = RequestDays::whereIn('status', ['PENDING', 'REJECTED'])
            ->with('user', 'user.departments', 'user.jobs')
            ->whereHas('user', function ($q) {
                $q->whereNull('deleted_at');
            })->get(['id', 'user_id', 'start_date', 'end_date', 'reason', 'photo_path']);

        /*$all_requests = RequestDays::whereIn('status', ['PENDING', 'REJECTED'])->get()->toArray();
        $show_requests = [];
        $show_requests = $all_requests;*/


        // permissions check
//        if ($user->request_access != 'none') {
//            foreach ($all_requests as $all_request) {
//                $approver_arr = [];
//                if (is_array($all_request['approvers'])) {
//                    foreach ($all_request['approvers'] as $approver_id => $approve) {
//                        if ($user->request_access == 'personal') {
//                            if (($approver_id == $user->id) && ($approve != 1)) {
//                                $all_request['approvers'] = NULL;
//                                $show_requests[] = $all_request;
//                            }
//                        } elseif ($user->request_access == 'full') {
//                            $approver = User::find($approver_id);
//                            $approver_arr[$approver->first_name . ' ' . $approver->last_name] = $approve;
//                        } else {
//                            $show_requests[] = $all_request;
//                        }
//                    }
//                    $all_request['approvers'] = $approver_arr;
//                }
//                if ($user->request_access == 'full') {
//                    $show_requests[] = $all_request;
//                }
//            }
//        }

//        $requests = array_map(function ($request) {
//            $info = DB::table('users')
//                    ->where('users.id', $request['user_id'])
//                    ->leftJoin('job_positions', 'users.job_position_id', '=', 'job_positions.id')
//                    ->leftJoin('departments', 'departments.id', '=', 'users.department_id')
//                    ->join('requests', 'requests.user_id', '=', 'users.id')
//                    ->select('users.*', 'job_positions.title as job_position_title', 'job_positions.id as job_position_id', 'departments.name as department_name',
//                        'requests.start_date as start')
//                    ->where('users.deleted_at', null)
//                    ->first();
//
//            if($info) {
//                $data['id'] = $request['id'];
//                $data['user'] = [
//                    'full_name' => $info->first_name . ' ' . $info->last_name,
////                    'department_id' => $info->department_id,
//                    'department_name' => $info->department_name,
//                    'company' => $info->company
//                ];
//                $data['reason'] = $request['reason'];
//                $data['description'] = $request['description'];
//                $data['start_date'] = Carbon::parse($request['start_date'])->format('d-m-Y');
//                $data['end_date'] = Carbon::parse($request['end_date'])->format('d-m-Y');
//
//                $dayCount = (calc_working_days($request['start_date'], $request['end_date'])) * 60;
//
//                $leave_time = convertTime($dayCount);
//
//                $data['working_days'] = $leave_time;
//                $data['approvers'] = $request['approvers'];
//                $data['photo_path'] = $request['photo_path'];
//
//                return $data;
//            }
//        }, $show_requests);

        $all_month_requests = RequestDays::where('status', 'APPROVED')
            ->with('user', 'user.departments')
            ->whereHas('user', function ($q) {
                $q->whereNull('deleted_at');
            })->get(['id', 'user_id', 'start_date', 'end_date', 'reason', 'photo_path'])->toArray();

        $month_requests = array_map(function ($request) {
            $data['id'] = $request['id'];
            $data['title'] = "{$request['user']['first_name']} {$request['user']['last_name']} ({$request['user']['departments']['name']})";
            $data['start'] = date("Y-m-d", strtotime($request['start_date']));
            $data['end'] = date("Y-m-d", strtotime($request['end_date'] . " +1 day"));
            $data['color'] = '#1cb57d'; //green

            return $data;
        }, $all_month_requests);

        //for modal "Create"
        // $all_users = User::select(DB::raw("CONCAT(first_name,' ',last_name) AS full_name"), 'id')->where("id", "=", 1)->get();
        // dd($all_users->pluck('full_name', 'id'));

        // $ProjectManagers = Employees::where('designation', 1)->get()->pluck('full_name', 'id');

        $all_users = User::where("id", "!=", 1)->get();
            
        $reasons = get_enums('requests', 'reason');
        $company_enum = get_enums('users', 'company');

        return view('selfservicemodule::user-requests.pending-requests', compact('requests', 'all_users', 'reasons', 'month_requests', 'company_enum'));
    }

    /**
     * Show the form for creating a new resource.
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application|Response|\Illuminate\View\View
     */
    public function create()
    {
        return view('selfservicemodule::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
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
        return view('selfservicemodule::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param Request $request
     * @return Response
     */
    public function edit(Request $request)
    {

        $request_id = $request->input('request_id');
        $request_info = RequestDays::findOrFail($request_id);

        $user = DB::table('users')
            ->where('users.id', $request_info->user_id)
            ->leftJoin('job_positions', 'users.job_position_id', '=', 'job_positions.id')
            ->leftJoin('departments', 'departments.id', '=', 'users.department_id')
            ->select('users.*', 'job_positions.title as job_position_title', 'job_positions.id as job_position_id', 'departments.name as department_name')
            ->where('users.deleted_at', null)
            ->first();

        $department_requests = RequestDays::where(['department_id' => $user->department_id, 'status' => 'APPROVED'])->get()->toArray();
        $department_requests = array_map(function ($request) {
            try {
                $user_info = User::findOrFail($request['user_id']);
                $data['title'] = $user_info->first_name . ' ' . $user_info->last_name;
                $data['start'] = Carbon::parse($request['start_date'])->format("Y-m-d");
                $data['end'] = Carbon::parse($request['end_date'])->addDay()->format("Y-m-d");
                $data['color'] = '#1cb57d';
                return $data;
            } catch (\Exception $ex) {
            }
        }, $department_requests);
        array_push($department_requests, [
            'title' => $user->first_name . ' ' . $user->last_name,
            'start' => Carbon::parse($request_info->start_date)->format("Y-m-d"),
            'end' => Carbon::parse($request_info->end_date)->addDay()->format("Y-m-d"),
            'color' => '#FF9900',
        ]);

        $calendar['events'] = $department_requests;

        return response()->json([
            'info' => $calendar,
            'request' => [
                'title' => $user->first_name . ' ' . $user->last_name,
                'start' => Carbon::parse($request_info->start_date)->format("Y-m-d"),
                'end' => Carbon::parse($request_info->end_date)->format("Y-m-d"),
                'color' => '#FF9900',
                'department' => $user->department_name,
            ]]);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request)
    {
//        $user = Sentinel::getUser();

        $request_id = $request->input('request_id');
        $status = $request->input('status');
        $rejected_description = $request->input('reject_description');

        $request_db = RequestDays::findOrFail($request_id);

        if ($rejected_description) {
            $request_db->reject_reason = $rejected_description;
        }

        $request_db->status = $status;

        /*if ($user->request_access == 'personal') {
            if ($status == 'APPROVED') {
                $approvers = $request_db->approvers;
                if (is_array($approvers)) {
                    foreach ($approvers as $approver_id => $approve) {
                        if (($approver_id == $user->id))
                            $approvers[$approver_id] = 1;
                    }
                }
            } else if ($status == 'REJECTED') {
                $approvers = $request_db->approvers;
                if (is_array($approvers)) {
                    foreach ($approvers as $approver_id => $approve) {
                        if (($approver_id == $user->id))
                            $approvers[$approver_id] = 0;
                    }
                }
            }
            $request_db->approvers = $approvers;
        } elseif ($user->request_access == 'full') {
            $request_db->status = $status;
        }*/

        $request_db->save();

        return response()->json(['status' => 'success']);
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy()
    {
    }

    public function manual_request(Request $request)
    {
        if($request->file !==null);

        $this->validate($request, [
            'user_id' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'reason' => 'required',
            //'photo_path' => 'required|mimes:jpg,jpeg,png,gif'
        ]);
     
        $fileName = null;

        if($request->file !==null)
        {
            $fileName = time().'.'.$request->file->extension();
            $request->file->move(public_path('images'), $fileName);
        }
        else
        {
            $fileName = 'no-report.png';
        }

        try {
            $department_id = User::findOrFail($request->input('user_id'));

            RequestDays::create([
                'user_id' => $request->input('user_id'),
                'department_id' => $department_id->department_id,
                'start_date' => $request->input('start_date'),
                'end_date' => $request->input('end_date'),
                'reason' => $request->input('reason'),
                'status' => 'PENDING',
                'photo_path' => $fileName,
                'description' => $request->input('description') ? $request->input('description') : '',
            ]);

            return back()->with(['flash_message' => 'Leave request successfully added!']);

        } catch (\Exception $e) {

            return back()->with(['flash_message' => 'Error: ' . $e]);
        }
    }

    public function history()
    {
        /*$all_requests = RequestDays::where('status', 'APPROVED')->get()->toArray();

        $requests = RequestDays::where('status', 'APPROVED')
            ->with('user', 'user.departments', 'user.jobs')
            ->whereHas('user', function ($q) {
                $q->whereNull('deleted_at');
            })->get(['id', 'user_id', 'start_date', 'end_date', 'reason', 'photo_path']);*/

        /*$requests = array_map(function ($request) {
            $info = DB::table('users')
                ->where('users.id', $request['user_id'])
                ->leftJoin('job_positions', 'users.job_position_id', '=', 'job_positions.id')
                ->leftJoin('departments', 'departments.id', '=', 'users.department_id')
                ->join('requests', 'requests.user_id', '=', 'users.id')
                ->select('users.*', 'job_positions.title as job_position_title', 'job_positions.id as job_position_id', 'departments.name as department_name',
                    'requests.start_date as start')
                ->where('users.deleted_at', null)
//                ->where('requests.start_date', "like", '%'.Carbon::now()->year.'%')
                ->first();

            if ($info) {
                $data['id'] = $request['id'];
                $data['user'] = [
                    'full_name' => $info->first_name . ' ' . $info->last_name,
                    'department_id' => $info->department_id,
                    'department_name' => $info->department_name
                ];
                $data['reason'] = $request['reason'];
                $data['description'] = $request['description'];
                $data['start_date'] = Carbon::parse($request['start_date'])->format('d-m-Y');
                $data['end_date'] = Carbon::parse($request['end_date'])->format('d-m-Y');

                $dayCount = (calc_working_days($request['start_date'], $request['end_date'])) * 60;
                $leave_time = convertTime($dayCount);
                $data['working_days'] = $leave_time;

                return $data;
            }

        }, $all_requests);*/

        /*return view('selfservicemodule::user-requests.requests-history', compact('requests'));*/

        $company_enum = get_enums('users', 'company');
        return view('selfservicemodule::user-requests.requests-history', compact('company_enum'));

    }

    public function delete_request($id)
    {
        try {

            $request = RequestDays::findOrFail($id);
            $request->delete();

            return response()->json(['status' => 'success', 'message' => 'Request successfully deleted!']);

        } catch (\Exception $e) {

            return response()->json(['status' => 'error', 'message' => $e]);

        }
    }

    public function edit_request($id)
    {
        try {

            $request = RequestDays::findOrFail($id);
            $user = User::findOrFail($request->user_id);
            return view('selfservicemodule::user-requests.history.edit', compact('request', 'user'));

        } catch (\Exception $e) {

            return response()->json(['status' => 'error', 'message' => $e], 404);
        }
    }

    public function update_request(Request $request)
    {
        $request_id = $request->input('request_id');
        $user_id = $request->input('user_id');
        $start = $request->input('start_date');
        $end = $request->input('end_date');
        $reason = $request->input('reason');
        $description = $request->input('description');

        try {
            $edit = RequestDays::findOrFail($request_id);

            $edit->user_id = $user_id ? $user_id : $edit->user_id;
            $edit->start_date = $start ? $start : $edit->start_date;
            $edit->end_date = $end ? $end : $edit->end_date;
            $edit->reason = $reason ? $reason : $edit->reason;
            $edit->description = $description ? $description : $edit->description;

            $edit->save();

            return response()->json(['status' => 'success', 'message' => 'ok', 'data' => $edit], 200);

        } catch (\Exception $e) {

            return response()->json(['status' => 'error', 'message' => $e], 404);
        }
    }

    public function loadTables()
    {
//        $user = Sentinel::getUser();

        $requests = RequestDays::where('status', 'APPROVED')
            ->with('user', 'user.departments', 'user.jobs')
            ->whereHas('user', function ($q) {
                $q->whereNull('deleted_at');
            })->get(['id', 'user_id', 'start_date', 'end_date', 'reason', 'photo_path']);

        $officialHolidays = OfficialHoliday::pluck('day')->toArray();
        $holidaysCarbonized = array_map(function($h){return Carbon::parse($h);}, $officialHolidays);

        /*$show_requests = [];*/

        /*if ($user->request_access == 'personal') {
            $all_requests = RequestDays::whereIn('status', ['PENDING', 'APPROVED'])->get()->toArray();

            foreach ($all_requests as $all_request) {
                if (is_array($all_request['approvers'])) {
                    foreach ($all_request['approvers'] as $approver_id => $approve) {
                        if ($approver_id == $user->id) {
                            if ($all_request['status'] == 'PENDING' && $approve == 1)
                                $show_requests[] = $all_request;
                            elseif ($all_request['status'] == 'APPROVED') {
                                $show_requests[] = $all_request;
                            }
                        }
                    }
                }
            }
        } elseif ($user->request_access == 'full') {
            $show_requests = RequestDays::where('status', 'APPROVED')->get()->toArray();
        }*/

        $years = DB::table('requests')->selectRaw('YEAR(start_date) as start')->where('status', 'APPROVED')->distinct()->orderBy('start')->get();

        $company_enum = get_enums('users', 'company');

        /*$requests = array_map(function ($request) {

            $info = DB::table('users')
                ->where('users.id', $request['user_id'])
                ->leftJoin('job_positions', 'users.job_position_id', '=', 'job_positions.id')
                ->leftJoin('departments', 'departments.id', '=', 'users.department_id')
                ->join('requests', 'requests.user_id', '=', 'users.id')
                ->select('users.*', 'job_positions.title as job_position_title', 'job_positions.id as job_position_id', 'departments.name as department_name', 'requests.start_date as start')
                ->where('users.deleted_at', null)
                ->first();
            if ($info) {
                $data['id'] = $request['id'];
                $data['user'] = [
                    'full_name' => $info->first_name . ' ' . $info->last_name,
                    'department_id' => $info->department_id,
                    'department_name' => $info->department_name
                ];
                $data['reason'] = $request['reason'];
                $data['description'] = $request['description'];
                $data['start_date'] = Carbon::parse($request['start_date'])->format('d-m-Y');
                $data['end_date'] = Carbon::parse($request['end_date'])->format('d-m-Y');
                $data['year'] = Carbon::parse($request['end_date'])->format('Y');

                $dayCount = (calc_working_days($request['start_date'], $request['end_date'])) * 60;
                $leave_time = convertTime($dayCount);
                $data['working_days'] = $leave_time;

                return $data;
            }

        }, $show_requests);*/

        /*$requests = array_filter($requests, function ($value) {
            return ($value !== null && $value !== false && $value !== '');
        });*/

        return view('selfservicemodule::user-requests.load-table', compact('requests', 'years', 'company_enum', 'holidaysCarbonized'));

    }
}

