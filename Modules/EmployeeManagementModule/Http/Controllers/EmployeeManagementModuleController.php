<?php

namespace Modules\EmployeeManagementModule\Http\Controllers;

use App\Helpers\ThumbnailGenerator;
use App\Http\Controllers\Controller;
use App\User;
use Barryvdh\DomPDF\Facade as PDF;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Modules\EmployeeManagementModule\Entities\Applicant;
use Modules\EmployeeManagementModule\Entities\Skill;
use Modules\EmployeeManagementModule\Entities\UserDocument;
use Modules\EmployeeManagementModule\Entities\UserExperience;
use Modules\EmployeeManagementModule\Entities\UserProject;
use Modules\EmployeeManagementModule\Entities\UserTransfer;
use Modules\SelfServiceModule\Entities\RequestDays;
use Modules\SystemSettingsModule\Entities\Department;
use Modules\SystemSettingsModule\Entities\JobPosition;
use Modules\SystemSettingsModule\Entities\Role;

/**
 * Include core controller to share global variables if needed
 * Krisid Misso
 */

use Modules\SystemSettingsModule\Entities\Training;
use Route;
use Validator;
use View;

class EmployeeManagementModuleController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application|Response|\Illuminate\View\View
     */
    public function index()
    {
        $users = User::with('jobs', 'departments')->where('id', '!=', '1')->Where('company','!=','Sisal Albania')->orWhere('company', '=', NULL)->get(['id', 'priority', 'first_name', 'last_name', 'department_id', 'job_position_id', 'contract_end', 'status', 'photo_path', 'company']);
    
        $status_enum = get_enums('users', 'status');
        $company_enum = get_enums('users', 'company');
        $company_transfer = get_enums('user_transfers','transfer_company');

        return view('employeemanagementmodule::index', compact('status_enum','company_transfer','company_enum'), ['users' => $users]);
    }


    public function sisal()
    {
        $users = User::with('jobs', 'departments')->where('id', '!=', '1')->where('company','=','Sisal Albania')->get(['id', 'priority', 'first_name', 'last_name', 'department_id', 'job_position_id', 'contract_end', 'status', 'photo_path', 'company']);
       
        $status_enum = get_enums('users', 'status');
        $company_enum = get_enums('users', 'company');
        $company_transfer = get_enums('user_transfers','transfer_company');

        return view('employeemanagementmodule::sisal', compact('status_enum','company_transfer','company_enum'), ['users' => $users]);
    }
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $departments = Department::all();
        $positions = JobPosition::all();
        $trainings = Training::all();
        $enumoption = get_enums('users', 'education');
        $status_enum = get_enums('users', 'status');
        $reason_enum = get_enums('user_experiences', 'quit_reason');
        $months = get_months();
        $gender_enum = ["F" => "Female", "M" => "Male"];
        $skills = Skill::get();

        return view('employeemanagementmodule::create', compact('enumoption', 'status_enum', 'reason_enum', 'trainings', 'months', 'gender_enum', 'skills'), ['departments' => $departments, 'positions' => $positions]);
    }

    /**
     * @param Request $request
     * @return array
     */
    public function store(Request $request)
    {
        $rules = [
            "user.first_name" => "required",
            "user.last_name" => "required",
            "user.birthday" => "required",
            "user.birthday.*" => "required",
            "user.email" => "required|email|unique:users,email",
            "user.address" => "required",
            "user.mobile_phone" => "required",
            "job.job_position_id" => "required",
            "job.department_id" => "required",
        ];
        $attributes = [
            'user.first_name' => 'firstname',
            'user.last_name' => 'lastname',
            'user.birthday' => 'birthday',
            'user.email' => 'email',
            'user.address' => 'address',
            'user.mobile_phone' => 'mobile',
            'docs.cv_path' => 'cv',
            'job.job_position_id' => 'job position',
            'job.department_id' => 'department',
            'user.birthday.0' => 'birthday date',
            'user.birthday.1' => 'birthday month',
            'user.birthday.2' => 'birthday year',
        ];

        $messages =  isset($request->applicant_id) ? ['required_without' => 'The cv field is required!'] : [] ;

        $validator = Validator::make($request->all(), $rules, $messages, $attributes);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator)->with([
                "languages" => $request->user["languages"]
            ]);
        }
        $thumbnail = new ThumbnailGenerator();

        if (isset($request->user["photo_path"])) {
            $imageName = date("YmdHis_") . $request->user["photo_path"]->getClientOriginalName();
            $save_photo = Storage::disk('public_images')->putFileAs('images', $request->user["photo_path"], $imageName);
        }

        if (isset($request->docs['cv_path'])) {
            $docName = date("YmdHis_") . $request->docs["cv_path"]->getClientOriginalName();
            $save_cv = Storage::disk("public")->putFileAs('docs', $request->docs['cv_path'], $docName);
            $fileUrl = Storage::url($save_cv);
            // $cvThumbnail = $thumbnail->thumbnailGenerator($request->docs['cv_path'], asset($fileUrl));
        } elseif (isset($request->applicant_id)) {
            $applicant = Applicant::find($request->applicant_id);
            if ($applicant)
                $save_cv = $applicant->cv_path;
            else {
                return response()->json([
                    "success" => false,
                    "message" => "Applicant not found",
                    "status" => "Not found"
                ], 404);
            }
        }

        $birthday = date("Y-m-d", strtotime(implode("-", $request->user['birthday'])));
        $languages = array_values(array_filter($request->user["languages"]));

        $req = [
            "birthday" => Carbon::parse($birthday),
            "password" => bcrypt("1234567"),
            "photo_path" => isset($save_photo) ? Storage::url($save_photo) : "images/user_avatar.jpg",
            "cv_path" => isset($save_cv) ? $save_cv : null,
            "languages" => $languages
        ];

        $format_request = array_except($request->user, ['birthday', 'cv_path', 'photo_path', 'skills', 'languages']) + $req;

        $user = User::create($format_request);
        $user->update($request->job);

        $skills = $request->skills;
        $user->skills()->attach($skills);

        $role = Role::where("name", "User")->first();

        if($role){
            $role->users()->attach($user);
        }

        UserExperience::create($request->experience + ["user_id" => $user->id]);

        if (isset($request->companyTrainings)) {
            $user->userTrainings()->sync($request->companyTrainings);
        }

//        if (isset($request->transfer_date) && isset($request->transfer_company)){
//            $userTransfer = new UserTransfer();
//            $userTransfer->transfer_date = $request->transfer_date;
//            $userTransfer->transfer_company = $request->transfer_company;
//            $userTransfer->user_id = $id;
//            $userTransfer->save();
//        }

        $userDocuments = [];
        if (isset($request->training['docs']) && count($request->training['docs']) > 0) {
            foreach ($request->training['docs'] as $doc) {
                if (isset($doc["title"]) && isset($doc["file"])) {
                    $docName = date("YmdHis_") . $doc["file"]->getClientOriginalName();
                    $save_doc = Storage::disk("public")->putFileAs('docs', $doc["file"], $docName);

                    $thumbnailUrl = $thumbnail->thumbnailGenerator($doc["file"], Storage::disk('public')->path($save_doc));

                    $userDocuments[] = [
                        "user_id" => $user->id,
                        "category_name" => "OTHER",
                        "file_name" => $doc["file"]->getClientOriginalName(),
                        "file_type" => $doc["file"]->getClientOriginalExtension(),
                        "file_size" => $doc["file"]->getClientSize(),
                        "file_path" => $save_doc,
                        "title" => $doc["title"],
                        "thumbnail" => asset($thumbnailUrl),
                    ];
                }
            }
        }

        if (isset($request->legal['docs']) && count($request->legal['docs']) > 0) {
            foreach ($request->legal['docs'] as $doc) {
                if (isset($doc["title"]) && isset($doc["file"])) {
                    $docNameLegal = date("YmdHis_") . $doc["file"]->getClientOriginalName();
                    $save_docLegal = Storage::disk("public")->putFileAs('docs', $doc["file"], $docNameLegal);

                    $thumbnailUrl = $thumbnail->thumbnailGenerator($doc["file"], Storage::disk('public')->path($save_docLegal));

                    $userDocuments[] = [
                        "user_id" => $user->id,
                        "category_name" => "LEGAL",
                        "file_name" => $doc["file"]->getClientOriginalName(),
                        "file_type" => $doc["file"]->getClientOriginalExtension(),
                        "file_size" => $doc["file"]->getClientSize(),
                        "file_path" => $save_docLegal,
                        "title" => $doc["title"],
                        "thumbnail" => asset($thumbnailUrl),
                    ];
                }
            }
        }

       /* if ($request->transfer['transfer_company'] != null && $request->transfer['transfer_date'] != null) {
            $userTransfer = $user->usersTransfer();
            $createdRecord = $userTransfer->create($request->transfer);
            try {
                $transfer = UserTransfer::find($createdRecord->id);
                $transfer->transfer_date = $request->transfer_date;
                $transfer->transfer_company = $request->transfer_company;
                $transfer->user_id = $request->id;
            }
            catch (\Exception $e) {
            }
        }*/

        if (count($userDocuments) > 0) {
            UserDocument::insert($userDocuments);
        }

        if (isset($request->applicant_id) || isset($request->internship_id)) {
            return response()->json([
                "success" => true,
                "message" => "Employee created successfully!",
                "status" => "Successfully created"
            ]);
        }
        return redirect()->back()->with(["success_created" => "Successfully created"]);
    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function show($id)
    {
        $user = User::getUserWithRelations($id);

        $trainings_count = DB::table('trainings')
            ->join('trainings_users', 'trainings_users.user_id', '=', 'trainings.id')
            ->where('trainings_users.user_id', '=', $id)
            ->count();

        $vacations = RequestDays::where('user_id', '=', $id)->where('status', 'APPROVED')->where('reason', '=', 'VACATION')->get()->toArray();

        $absences_days = 0;
        $vacation_days = 0;

        array_map(function ($absence) use (&$absences_days) {

            $absences_days += calc_working_days($absence['start_date'], $absence['end_date']);
        }, $vacations);

        array_map(function ($vacation) use (&$vacation_days) {

            $vacation_days += calc_working_days($vacation['start_date'], $vacation['end_date']);

        }, $vacations);

        return view('employeemanagementmodule::show', compact('user', 'trainings_count', 'absences_days', 'vacation_days'));
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit($id)
    {
        $employee = User::findOrFail($id);
        $job_positions = JobPosition::all();
        $departments = Department::all();
        $trainings = Training::all();
        $status_enum = get_enums('users', 'status');
        $company_user = get_enums('users', 'company');
        $company_project = get_enums('user_projects', 'project_company');
        $company_transfer = get_enums('user_transfers','transfer_company');
        $project_type = get_enums('user_projects', 'project_type');
        $education_enum = get_enums('users', 'education');
        $reason_enum = get_enums('user_experiences', 'quit_reason');
        $skills = Skill::get();

        $editedProject = UserProject::all()->toArray();
        $editedTransfer = UserTransfer::all()->toArray();

        $trainings_count = DB::table('trainings')
            ->join('trainings_users', 'trainings_users.user_id', '=', 'trainings.id')
            ->where('trainings_users.user_id', '=', $id)
            ->count();

        $absences = RequestDays::where('user_id', '=', $id)->where('status', 'APPROVED')->where('reason', '!=', 'VACATION')->get()->toArray();
        $vacations = RequestDays::where('user_id', '=', $id)->where('status', 'APPROVED')->where('reason', '=', 'VACATION')
            ->where('start_date', "like", '%'.Carbon::now()->year.'%')
            ->get()->toArray();

        $dayCount = 0;
        $vacation_days = 0;

        array_map(function ($absence) use (&$dayCount) {
            $dayCount += (calc_working_days($absence['start_date'], $absence['end_date']))*60;
        }, $absences);
        $dayCount = convertTime($dayCount);

        array_map(function ($vacation) use (&$vacation_days) {

            $vacation_days = ($vacation_days + calc_working_days($vacation['start_date'], $vacation['end_date'])/9);
        }, $vacations);
        //dd($vacation_days);
        $gender_enum = ["F" => "Female", "M" => "Male"];

        $userTransfers = $employee->usersTransfer;
//        dd($userTransfers);

        return view(
            'employeemanagementmodule::edit-employee',
            compact('userTransfers', 'status_enum', 'editedProject','editedTransfer','education_enum','project_type','company_project','company_transfer', 'company_user','departments', 'job_positions', 'employee', 'reason_enum', 'trainings', 'trainings_count', 'dayCount', 'vacation_days','gender_enum', 'skills')
        );
    }

    public function editProject($id)
    {
        $company_project = get_enums('user_projects', 'project_company');
        $company_transfer = get_enums('user_transfers', 'transfer_company');
        $project_type = get_enums('user_projects', 'project_type');
        $skills = Skill::get();
        $editedProject = UserProject::findOrFail($id);
        $editedTransfer = UserTransfer::findOrFail($id);

        return view('employeemanagementmodule::edit-project', compact('editedProject','editedTransfer','project_type','company_project','company_transfer','skills'));
    }
    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $rules = [
            "user.first_name" => "required",
            "user.last_name" => "required",
            "user.birthday" => "required",
            "user.birthday.*" => "required",
            "user.email" => "required|email|unique:users,email," . $id,
            "user.address" => "required",
            "user.mobile_phone" => "required",
            "job.job_position_id" => "required",
            "job.department_id" => "required",
        ];

        $attributes = [
            'user.first_name' => 'firstname',
            'user.last_name' => 'lastname',
            'user.birthday' => 'birthday',
            'user.email' => 'email',
            'user.address' => 'address',
            'user.mobile_phone' => 'mobile',
            'docs.cv_path' => 'cv',
            'job.job_position_id' => 'job position',
            'job.department_id' => 'department',
            'user.birthday.0' => 'birthday date',
            'user.birthday.1' => 'birthday month',
            'user.birthday.2' => 'birthday year'
        ];
        $validator = Validator::make($request->all(), $rules, [], $attributes);

        if ($validator->fails()) {

            $request->flash();
            return redirect()->route('module.employee.edit', ['id' => $id])->withInput($request->all())->withErrors($validator)->with([
                "languages" => $request->user["languages"]
            ]);
        }

        try {
            $user = User::find($id);
        }
        catch (\Exception $e) {
            $user = false;
        }

        if (!$user) {
            return response()->json([
                "success" => false,
                "message" => "User not found",
                "status" => "Not found"
            ], 404);
        }

        $thumbnail = new ThumbnailGenerator();

        if (isset($request->user["photo_path"])) {
            $imageName = date("YmdHis_") . $request->user["photo_path"]->getClientOriginalName();
            $save_photo = Storage::disk('public_images')->putFileAs('images', $request->user["photo_path"], $imageName);
            Storage::delete($user->photo_path);
        }

        if (isset($request->user['cv_path'])) {
            $docName = date("YmdHis_") . $request->user["cv_path"]->getClientOriginalName();
            $save_cv = Storage::disk("public")->putFileAs('docs', $request->user['cv_path'], $docName);
            $fileUrl = Storage::url($save_cv);
            Storage::delete($user->cv_path);
        }

        $birthday = date("Y-m-d", strtotime(implode("-", $request->user['birthday'])));
        $languages = array_values(array_filter($request->user["languages"]));

        $req = [
            "birthday" => Carbon::parse($birthday),
            "photo_path" => isset($save_photo) ? Storage::url($save_photo) : $user->photo_path,
            "cv_path" => isset($save_cv) ? $save_cv : $user->cv_path,
            "languages" => $languages,
        ];

        $format_request = array_except($request->user, ['birthday', 'cv_path', 'photo_path', 'skills', 'languages']) + $req;

        if(isset($request->job["unlimited_contract"]))
            $user->update($format_request + $request->job + $request->project);

        if(!isset($request->job["unlimited_contract"]))
            $user->update($format_request + $request->job + $request->project + ["unlimited_contract" => 0]);

        if ($request->project['project_company'] != null && $request->project['project_type'] != null) {
            $userProject = $user->projects();
            $createdRecord = $userProject->create($request->project);
            try {
                $project = UserProject::find($createdRecord->id);
                $pro_skills = $request->project_skills;
                $project->projectSkills()->detach();
                $project->projectSkills()->attach($pro_skills);
            }
            catch (\Exception $e) {
            }
        }

        /*if ($request->transfer['transfer_company'] != null && $request->transfer['transfer_date'] != null) {
            $userTransfer = $user->usersTransfer();
            $createdRecord = $userTransfer->create($request->transfer);
            try {
                $transfer = UserTransfer::find($createdRecord->id);
                $transfer->transfer_date = $request->transfer_date;
                $transfer->transfer_company = $request->transfer_company;
                $transfer->save();
            }
            catch (\Exception $e) {
            }
        }*/


        if (isset($request->transfer_date) && isset($request->transfer_company)){
            $userTransfer = new UserTransfer();
            $userTransfer->transfer_date = Carbon::parse($request->transfer_date)->format('Y-m-d');
            $userTransfer->transfer_company = $request->transfer_company;
            $userTransfer->user_id = $id;
            $userTransfer->save();
        }

        $userJob = $user->userExperiences();
        if (count($userJob->get()) > 0) {
            $userJob->first()->update($request->experience);
        } else {
            $userJob->create($request->experience);
        }

        $user->userTrainings()->detach();
        if (isset($request->companyTrainings)) {
            $user->userTrainings()->sync($request->companyTrainings);
        }

        $userDocuments = [];
        if (isset($request->training['docs']) && count($request->training['docs']) > 0) {
            foreach ($request->training['docs'] as $doc) {
                if (isset($doc["title"]) && isset($doc["file"])) {
                    $docName = date("YmdHis_") . $doc["file"]->getClientOriginalName();
                    $save_doc = Storage::disk("public")->putFileAs('docs', $doc["file"], $docName);
//                    $thumbnailUrl = $thumbnail->thumbnailGenerator($doc["file"], Storage::disk('public')->path($save_doc));

                    $userDocuments[] = [
                        "user_id" => $user->id,
                        "category_name" => "OTHER",
                        "file_name" => $doc["file"]->getClientOriginalName(),
                        "file_type" => $doc["file"]->getClientOriginalExtension(),
                        "file_size" => $doc["file"]->getClientSize(),
                        "file_path" => $save_doc,
                        "title" => $doc["title"],
                        "thumbnail" => asset($save_doc),
                    ];
                }
            }
        }
        if (isset($request->legal['docs']) && count($request->legal['docs']) > 0) {
            foreach ($request->legal['docs'] as $doc) {
                if (isset($doc["title"]) && isset($doc["file"])) {
                    $docNameLegal = date("YmdHis_") . $doc["file"]->getClientOriginalName();
                    $save_docLegal = Storage::disk("public")->putFileAs('docs', $doc["file"], $docNameLegal);
                    //$thumbnailUrl = $thumbnail->thumbnailGenerator($doc["file"], Storage::disk('public')->path($save_docLegal));

                    $userDocuments[] = [
                        "user_id" => $user->id,
                        "category_name" => "LEGAL",
                        "file_name" => $doc["file"]->getClientOriginalName(),
                        "file_type" => $doc["file"]->getClientOriginalExtension(),
                        "file_size" => $doc["file"]->getClientSize(),
                        "file_path" => $save_docLegal,
                        "title" => $doc["title"],
                        "thumbnail" => asset($save_docLegal),
                    ];
                }
            }
        }
        if (count($userDocuments) > 0) {
            UserDocument::insert($userDocuments);
        }

        return response()->json([
            "success" => true,
            "message" => "Successfully Updated",
            "status" => "Ok",
        ], 200);
    }

    public function searchProject(Request $request, $id)
    {
        try{
            $from = $request->input('from_evaluation') ;
            $to = $request->input('to_evaluation') ;
            $projects = DB::table('user_projects')
                ->where('user_id', '=', $id)
                ->where('unlimited_project','=', 0)
                ->where('evaluation_date','>',$from)
                ->where('evaluation_date','<', $to)->get()
            ;

            $returnHTML = view('employeemanagementmodule::employee-work-box', compact('projects'))->render();

            return response()->json([
                "projects" => $returnHTML,
                "success" => true,
                "message" => "Successfully ",
                "status" => "Ok",
            ], 200);
        }
        catch (\Exception $e){
            return response()->json([
                "projects" => null,
                "success" => false,
                "message" => $e->getMessage(),
                "status" => "Not Found",
            ], 404);
        }
    }
    
    public function updateProject(Request $request, $id)
    {
        try {
            $userProject = UserProject::find($id);
            if(isset($request->job["unlimited_project"])){
                $userProject->update($request->project);
            }
            if(!isset($request->job["unlimited_project"])){
                $userProject->update($request->project + ["unlimited_project" => 0]);
            }
            $pro_skills = $request->project_skills;
            $userProject->projectSkills()->detach();
            $userProject->projectSkills()->attach($pro_skills);

            return response()->json([
                "success" => true,
                "message" => "Successfully Updated",
                "status" => "Ok",
            ], 200);
        }
        catch (\Exception $e) {
            return response()->json([
                "success" => false,
                "message" => "Project not found",
                "status" => "Not found"
            ], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param Request $request
     * @param $id
     * @return Response
     */
    public function destroy(Request $request, $id)
    {
        $user = User::find($id);
        if ($user) {

            $user->update(["quit_reason" => $request->quit_reason]);
            $user->delete();

            return response()->json([
                "success" => true,
                "message" => "Successfully Deleted",
                "status" => "Ok",
            ], 200);
        }

        return response()->json([
            "success" => false,
            "message" => "Employee not deleted",
            "status" => "Unprocessable Entity",
        ], 422);
    }

    public function destroyProject($id)
    {
        $project = UserProject::where('id', $id);
        if($project){
            $project->delete();
            return response()->json([
                "success" => true,
                "message" => "Successfully Deleted",
                "status" => "Ok",
            ], 200);
        }

        return response()->json([
            "success" => false,
            "message" => "project not deleted",
            "status" => "Unprocessable Entity",
        ], 422);
    }

    private function validateInput($request)
    {
        $this->validate($request, [
            'first_name' => 'required|max:190',
            'last_name' => 'required|max:190',
            'email' => 'required|max:190|email|unique:users',
            'mobile_phone' => 'required|max:190',
            'bDay' => 'required|min:1|max:31',
            'bMonth' => 'required|min:1|max:12|size:2',
            'bYear' => 'required',
            'education' => 'nullable',
            'address' => 'required|max:190',
            'languages' => 'nullable|max:190',
            'reference' => 'nullable|max:190',
            'social_network_links.*' => 'nullable',
            'photo_path' => 'nullable',
            'status' => 'nullable',
            'contract_start' => 'nullable|date',
            'contract_end' => 'nullable|date',
            'emergency_numbers' => 'nullable|max:190',
            'city_id' => 'nullable',
            'department_id' => 'nullable',
            'job_position_id' => 'nullable',
            'start_date' => '',
            'left_date' => '',
            'position_title' => '',
            'company' => '',
            'quit_reason' => ''
        ]);
    }
    /**
     * Search state from database base on some specific constraints
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $order_by = $request->input('order_by');
        $departmants = DB::table('departments')
            ->select('departments.*')
            ->get();

        $constraints = [
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'status' => $request->input('status_name')
        ];
        $users = $this->doSearchingQuery($constraints, $order_by);

        return response()->json(['users' => $users, 'departments' => $departmants, 'searchingVals' => $constraints,]);
    }

    private function doSearchingQuery($value, $order_by)
    {
        switch ($order_by) {
            case 'alphabet':
                $fld = 'users.first_name';
                $ord = 'ASC';
                break;
            case 'contract':
                $fld = 'users.contract_end';
                $ord = 'DESC';
                break;
            default:
                $fld = 'users.first_name';
                $ord = 'ASC';
                break;
        }

        $result = User::with(['jobs', 'departments'])->where("first_name", 'like', '%' . $value["first_name"] . '%')->where('id', '!=', '1');

        if(isset($value["last_name"]))
            $result->orWhere("last_name", 'like', '%' . $value["last_name"] . '%');

        if(isset($value["status"]))
            $result->orWhere("status", 'like', '%' . $value["status"] . '%');

        return $result->orderBy($fld, $ord)->get();
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroyDocument($id)
    {
        $user = UserDocument::where("id", "!=", 1)->where("id", $id)->first();
        if ($user) {
            $user->delete();
            return response()->json([
                "success" => true,
                "message" => "Successfully Deleted",
                "status" => "Ok",
            ], 200);
        }

        return response()->json([
            "success" => false,
            "message" => "Employee not deleted",
            "status" => "Unprocessable Entity",
        ], 422);
    }

    public function downloadUserDetails($id)
    {
        $user = User::getUserWithRelations($id);

        $filename = $user->first_name . " " . $user->last_name . "_" . date("YmdHis");
        $html = View::make("employeemanagementmodule::details", compact('user'))->render();
        $pdf = PDF::loadHtml($html);
        return $pdf->download($filename . ".pdf");
    }

    public function googleLineChart($id)
    {
        $employee = User::findOrFail($id);
        $project = $employee->projects;
        $visitor = collect($project); //collect projects from a specific user
        $headerArray[] = ['Date','Performance'];
        foreach ($visitor as $key => $value) {
            $time = strtotime($value->evaluation_date);
            $newformat = date('Y-m-d',$time);
            $result[++$key] = [$newformat, (int)$value->performance_level];
        }

        usort($result, function($a, $b) {
            return ($a[0] < $b[0]) ? -1 : 1;
        });
        $result = array_merge($headerArray, $result);

        return view('employeemanagementmodule::google-line-chart')
            ->with('visitor',json_encode($result));
    }

}