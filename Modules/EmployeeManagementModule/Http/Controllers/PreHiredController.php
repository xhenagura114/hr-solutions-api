<?php

namespace Modules\EmployeeManagementModule\Http\Controllers;

use App\Http\Controllers\Controller;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\EmployeeManagementModule\Entities\Applicant;
use Illuminate\Support\Facades\Storage;
use Modules\EmployeeManagementModule\Entities\Skill;
use Modules\SystemSettingsModule\Entities\Department;
use Modules\SystemSettingsModule\Entities\JobPosition;
use Modules\SystemSettingsModule\Entities\JobVacancy;
use Modules\SystemSettingsModule\Entities\Training;
use Validator;

class PreHiredController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $job_vacancies_all = JobVacancy::get();
        $job_vacancies = Applicant::with('jobVacancies')->distinct()->get(['job_vacancy_id']);
        $applicants = Applicant::with('jobVacancies')->where('status', 'Interview Done')->where('response', 'Yes')->distinct()->get(['quit_date']);
        $gender_enum = ["F" => "Female", "M" => "Male"];
        $statuses = get_enums('applicants', 'status');
        $skills = Skill::get();
        $reason_enum = get_enums('applicant_experiences', 'quit_reason');
        $economic_response = get_enums('applicants', 'response');
        $italian = get_enums('applicants', 'italian_language');

        return view('employeemanagementmodule::pre-hired.index', compact('job_vacancies', 'job_vacancies_all', 'gender_enum', 'applicants', 'statuses', 'skills', 'reason_enum', 'economic_response', 'italian'));
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
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $rules = [
            'first_name_create' => 'required',
            'last_name_create' => 'required',
            'email_create' => 'required',
            'contact_create' => 'required',
            'gender' => 'required',
            'status' => 'required',
        ];

        $attributes = [
            'first_name_create' => 'firstname',
            'last_name_create' => 'lastname',
            'email_create' => 'email',
            'contact_create' => 'contact',
            'docs.cv_path' => 'cv',
            'docs.form_path' => 'scan',
            'job_position' => 'job vacancy',
            'status' => 'status',
        ];

        $validator = Validator::make($request->all(), $rules, [], $attributes);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $skills = $request->skills;

        $createRequest = [
            "first_name" => $request->first_name_create,
            "last_name" => $request->last_name_create,
            "job_vacancy_id" => $request->job_position,
            "email" => $request->email_create,
            "contact" => $request->contact_create,
            "gender" => $request->gender,
            "status" => $request->status,
            "application_date" => $request->application_date,

        ];
        if (isset($request->docs['cv_path'])) {
            $docName = date("YmdHis_") . $request->docs["cv_path"]->getClientOriginalName();
            $save_cv = Storage::disk("public")->putFileAs('uploads', $request->docs['cv_path'], $docName);
            $createRequest["cv_path"] = $save_cv;
        }

        if (isset($request->docs['form_path'])) {
            $docName = date("YmdHis_") . $request->docs["form_path"]->getClientOriginalName();
            $scan_cv = Storage::disk("public")->putFileAs('scan', $request->docs['form_path'], $docName);
            $createRequest["form_path"] = $scan_cv;
        }


        $applicant = new Applicant();
        $response = $this->applyChanges($applicant, $createRequest, 'create');

        if ($response) {
            $response->skills()->attach($skills);
            return redirect()->route('module.applicants.index')->with(['flash_message' => 'Applicant added successfully!']);
        }

        return redirect()->route('module.applicants.index')->with(['flash_message' => 'An error occurred! Applicant couldn\'t be created!']);
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
    public function edit($id)
    {
        $applicant = Applicant::findOrFail($id);
        $job_vacancies_all = JobVacancy::get();
        $gender_enum = get_enums('applicants', 'gender');
        $statuses = get_enums('applicants', 'status');
        $skills = Skill::get();
        $italian = get_enums('applicants', 'italian_language');
        $reason_enum = get_enums('applicant_experiences', 'quit_reason');
        $economic_response = get_enums('applicants', 'response');

        return view('employeemanagementmodule::pre-hired.edit', compact('job_vacancies_all', 'applicant', 'gender_enum', 'statuses', 'skills', 'italian', 'reason_enum', 'economic_response'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $rules = [
            'user.email' => 'required',
            'user.job_vacancy_id' => 'required'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 200);
        }

        $save_cv = null;
        $save_scan = null;

        $user = Applicant::findOrFail($id);

        if (isset($request->user['cv_path'])) {
            $docName = date("YmdHis_") . $request->user["cv_path"]->getClientOriginalName();
            $save_cv = Storage::disk("public")->putFileAs('uploads', $request->user['cv_path'], $docName);
        }

        if (isset($request->user['form_path'])) {
            $scanName = date("YmdHis_") . $request->user["form_path"]->getClientOriginalName();
            $save_scan = Storage::disk("public")->putFileAs('scan', $request->user['form_path'], $scanName);
        }
        dd($request->user['form_path']);
        $skills = $request->skills_edit;
        $user->skills()->detach();
        $user->skills()->attach($skills);

        $cv = ($save_cv !== null) ? ["cv_path" => $save_cv] : [];
        $scan = ($save_scan !== null) ? ["form_path" => $save_scan] : [];

        $createRequest = array_except($request->user, ['cv_path', 'form_path']) + $cv + $scan;
        $response = $this->applyChanges($user, $createRequest, 'update');

        if ($response)
            return response()->json([
                "success" => true,
                "message" => "Applicant updated successfully!",
                "status" => "Ok",
            ], 200);

        return response()->json([
            "success" => false,
            "message" => "An error occurred",
            "status" => "Error",
        ], 500);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     *
     */
    public function destroy($id)
    {
        $applicant = Applicant::where('id', $id);
        if ($applicant) {
            $applicant->delete();
            return response()->json([
                "success" => true,
                "message" => "Successfully Deleted",
                "status" => "Ok",
            ], 200);
        }

        return response()->json([
            "success" => false,
            "message" => "Applicant not deleted",
            "status" => "Unprocessable Entity",
        ], 422);
    }

    /**
     * Create employee with data from applicant
     * @return Response
     */
    public function approve($id)
    {
        $applicant = Applicant::with('jobVacancies')->findOrFail($id);
        $departments = Department::all();
        $positions = JobPosition::all();
        $trainings = Training::all();
        $gender_enum = ["F" => "Female", "M" => "Male"];
        $enumoption = get_enums('users', 'education');
        $status_enum = get_enums('users', 'status');
        $reason_enum = get_enums('user_experiences', 'quit_reason');
        $months = get_months();
        $skills = Skill::get();
        $company_user = get_enums('users', 'company');
        return view('employeemanagementmodule::pre-hired.approve', compact('applicant', 'enumoption', 'gender_enum', 'status_enum', 'reason_enum', 'trainings', 'months', 'skills','company_user'), ['departments' => $departments, 'positions' => $positions]);
    }

    public function loadTable()
    {
        $job_vacancies_all = JobVacancy::get();
        $job_vacancies = Applicant::with('jobVacancies')->distinct()->get(['job_vacancy_id']);
        $applicants = Applicant::with('jobVacancies')->where('status', 'Interview Done')->where('response', 'Yes')->get();

        return view('employeemanagementmodule::pre-hired.load-table', compact('job_vacancies', 'job_vacancies_all', 'applicants'));
    }

    /**
     * @param Applicant $object
     * @param $data
     * @param $type
     * @return Applicant|void
     */
    protected function applyChanges(Applicant $object, $data, $type)
    {
        try {
            if ($type === 'update')
                $object->update($data);

            else
                return $object->create($data);
            return true;
        } catch (\Exception $e) {
            \Log::info($e);
            return;
        }
    }
}
