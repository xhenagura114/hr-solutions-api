<?php

namespace Modules\EmployeeManagementModule\Http\Controllers;

use App\Http\Controllers\Controller;
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
use Illuminate\Support\Facades\DB;


class ApplicantsController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application|Response|\Illuminate\View\View
     */
    public function index()
    {
        $job_vacancies_all = JobVacancy::get();
        $job_vacancies = Applicant::with('jobVacancies')->distinct()->get(['job_vacancy_id']);
        //$gender_enum = get_enums('applicants', 'gender');
        $applicants = Applicant::with('jobVacancies')->get();
        $gender_enum = ["F" => "Female", "M" => "Male"];
        $statuses = get_enums('applicants', 'status');
        $skills = Skill::get();

        return view('employeemanagementmodule::applicants.index', compact('job_vacancies', 'job_vacancies_all', 'gender_enum', 'applicants', 'statuses', 'skills'));
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
            'comment' => 'nullable',
        ];

        $attributes = [
            'first_name_create' => 'firstname',
            'last_name_create' => 'lastname',
            'email_create' => 'email',
            'contact_create' => 'contact',
            'docs.cv_path' => 'cv',
            'job_position' => 'job vacancy',
            'status' => 'status',
            'comment' => 'comment'
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
            "comment" => $request->comment,
        ];


        if (isset($request->docs['cv_path'])) {
            $docName = date("YmdHis_") . $request->docs["cv_path"]->getClientOriginalName();
            $save_cv = Storage::disk("public")->putFileAs('docs', $request->docs['cv_path'], $docName);
            $createRequest["cv_path"] = $save_cv;
        }

//        $applicant = new Applicant();

        $response = Applicant::create($createRequest);

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

        return view('employeemanagementmodule::applicants.edit', compact('job_vacancies_all', 'applicant', 'gender_enum', 'statuses', 'skills'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @return Response
     */
    public function update(Request $request, $id)
    {

//        return response()->json(['data'=>$request]);

        $rules = [
            'user.first_name' => 'required',
            'user.last_name' => 'required',
            'user.email' => 'required',
            'user.contact' => 'required',
            'user.gender' => 'required',
            'user.status' => 'required',

            // 'user.job_position' => 'required'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 200);
        }

        $save_cv = null;

        $applicant = Applicant::findOrFail($id);

        $applicant->comment = $request->input('comment');
        $applicant->save();

        if (isset($request->user['cv_path'])) {
            $docName = date("YmdHis_") . $request->user["cv_path"]->getClientOriginalName();
            $save_cv = Storage::disk("public")->putFileAs('docs', $request->user['cv_path'], $docName);
        }

        $skills = $request->skills_edit;
        $applicant->skills()->detach();
        $applicant->skills()->attach($skills);


        $cv = ($save_cv !== null) ? ["cv_path" => $save_cv] : [];

        $createRequest = array_except($request->user, ['cv_path']) + $cv;
        $response = $this->applyChanges($applicant, $createRequest, 'update');

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

    public function transferSkills()
    {
        $db_ext = \DB::connection('mysql_external');
//        all skills from database, registered by employees and applicants
        $skills = $db_ext->table('user_skills')
            ->select(['user_skills.skill_id', 'user_skills.month_of_experience', 'user_skills.level', 'user_skills.seniority', 'user_skills.other_technology',
                'user_skills.user_id', 'users.*'])
            ->join('users', 'user_skills.user_id', '=', 'users.id')
//            ->where('user_skills.created_at', '>', DB::raw('DATE_SUB(NOW(), INTERVAL 1 MONTH)'))
            ->get()
            ->groupBy('email');

        foreach ($skills as $key => $skill) {
            $user = DB::table('users')->where('email', '=', $key)->first();

            if ($user == null) {
                $applicant = DB::table('applicants')->where('email', '=', $key)->first();
                if ($applicant == null) {
                    foreach ($skill as $sk) {
                   //add new applicant in "applicants" table, HRMS db
                        $addApplicant = DB::table('applicants')->insertGetId(
                                ['first_name' => $sk->name,
                                'last_name' => $sk->lastname,
                                'email' => $sk->email,
                                'created_at' => $sk->created_at,
                                'updated_at' => $sk->updated_at,
                                'deleted_at' => $sk->seniority,
                                'actual_company' => $sk->actual_company,
                                'actual_position' => $sk->actual_position,
                                'professional_self_evaluation' => $sk->professional_self_evaluation,
                                'soft_skills' => $sk->soft_skills,
                                'seniority' => $sk->seniority ]
                            
                        );

                        foreach ($skill as $sk) {

                            $insert_skills = DB::table('applicant_skills')->insert(
                                array(
                                    'applicant_id' => $addApplicant->applicant_id,
                                    'skill_id' => $sk->skill_id,
                                    'month_of_experience' => $sk->month_of_experience,
                                    'level' => $sk->level,
                                    'other_technology' => $sk->other_technology,
                                    'seniority' => $sk->seniority
                                )
                            );
                        }
                    }
                } else {
                    $delete_skills = DB::table('applicant_skills')->where('applicant_id', '=', $applicant->id)->delete();
                    foreach ($skill as $sk) {
                        $insert_skills = DB::table('applicant_skills')->insert(
                            array(
                                'applicant_id' => $applicant->id,
                                'skill_id' => $sk->skill_id,
                                'month_of_experience' => $sk->month_of_experience,
                                'level' => $sk->level,
                                'other_technology' => $sk->other_technology,
                                'seniority' => $sk->seniority
                            )
                        );
                    }
                }
            } else {
                $delete_skills = DB::table('user_skills')->where('user_id', '=', $user->id)->delete();
                foreach ($skill as $sk) {
                    $insert_skills = DB::table('user_skills')->insert(
                        array(
                            'user_id' => $user->id,
                            'skill_id' => $sk->skill_id,
                            'month_of_experience' => $sk->month_of_experience,
                            'level' => $sk->level,
                            'other_technology' => $sk->other_technology,
                            'seniority' => $sk->seniority
                        )
                    );
                }
            }

            foreach ($skill as $sk) {
                $userSkills = $db_ext->table('user_skills')->where('user_id', '=', $sk->user_id)->delete();
            }

            $usertest = $db_ext->table('users')->where('email', '=', $key)->delete();
        }
        return redirect()->back()->with(['flash_message' => 'Skills transfered successfully!']);
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
        return view('employeemanagementmodule::applicants.approve', compact('applicant', 'enumoption', 'gender_enum', 'status_enum', 'reason_enum', 'trainings', 'months'), ['departments' => $departments, 'positions' => $positions]);
    }

    public function loadTable()
    {
        $job_vacancies_all = JobVacancy::get();
//        $job_vacancies = JobVacancy::with('applicant')->distinct()->get(['id']);
        $job_vacancies = Applicant::with('jobVacancies')->distinct()->get(['job_vacancy_id']);
        $applicants = Applicant::with('jobVacancies:id,position')
            ->orderBy('application_date', 'desc')
            ->get([
                'id',
                'job_vacancy_id',
                'first_name',
                'last_name',
                'email',
                'application_date',
                'contact',
                'cv_path',
                'status',
                'comment'
            ]);

        return view('employeemanagementmodule::applicants.load-table', compact('job_vacancies', 'job_vacancies_all', 'applicants'));
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
