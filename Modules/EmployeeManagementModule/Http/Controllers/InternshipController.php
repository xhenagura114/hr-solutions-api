<?php

namespace Modules\EmployeeManagementModule\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Modules\EmployeeManagementModule\Entities\Internship;
use Modules\SystemSettingsModule\Entities\Department;
use Modules\SystemSettingsModule\Entities\JobPosition;
use Modules\SystemSettingsModule\Entities\Training;
use Validator;

class InternshipController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $job_positions = JobPosition::get();
        //$gender_enum = get_enums('applicants', 'gender');
        $internships = Internship::get();
        $gender_enum = ["F" => "Female", "M" => "Male"];
        $enumoption = get_enums('internships', 'education');
        return view('employeemanagementmodule::internship.index', compact('job_positions', 'gender_enum', 'enumoption', 'internships'));
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
        $rules = [
            'first_name_create' => 'required',
            'last_name_create'  => 'required',
        ];

        $attributes = [
            'first_name_create' => 'firstname',
            'last_name_create'  => 'lastname',
            'email_create'      => 'email',
            'contact_create'    => 'contact',
            'gender_create'     => 'gender',
            'interests_create'  => 'interests',
            'institution_create'  => 'institution',
            'education_create'  => 'education',
            'studying_for_create'  => 'studying for',
            'comments_create'  => 'comments',
        ];

        $validator = Validator::make($request->all(), $rules, [], $attributes);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $createRequest = [
            "first_name" =>  $request->first_name_create,
            "last_name" =>  $request->last_name_create,
            "email" =>  $request->email_create,
            "contact" =>  $request->contact_create,
            "gender" =>  $request->gender_create,
            "interests" => $request->interests_create,
            "institution" => $request->institution_create,
            "education" => $request->education_create,
            "studying_for" => $request->studying_for_create,
            "comments" => $request->comments_create,
        ];

        $internship = new Internship;

        $response = $this->applyChanges($internship, $createRequest, 'create');

        if ($response)
            return redirect()->route('module.internship.index')->with(['flash_message' => 'Internship added successfully!']);

        return redirect()->route('module.internship.index')->with(['flash_message' => 'An error occurred! Internship couldn\'t be created!']);
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
        $job_positions = JobPosition::get();
        $internship = Internship::findOrFail($id);
        $gender_enum = ["F" => "Female", "M" => "Male"];
        $enumoption = get_enums('internships', 'education');

        return view('employeemanagementmodule::internship.edit', compact('job_positions', 'gender_enum', 'enumoption', 'internship'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $rules = [
            'first_name_edit' => 'required',
            'last_name_edit'  => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()){
            return response()->json($validator->errors(), 200);
        }

        $updateRequest = [
            "first_name" =>  $request->first_name_edit,
            "last_name" =>  $request->last_name_edit,
            "email" =>  $request->email_edit,
            "contact" =>  $request->contact_edit,
            "gender" =>  $request->gender_edit,
            "interests" => $request->interests_edit,
            "institution" => $request->institution_edit,
            "education" => $request->education_edit,
            "studying_for" => $request->studying_for_edit,
            "comments" => $request->comments_edit,
        ];

        $internship = Internship::findOrFail($id);

        $response = $this->applyChanges($internship, $updateRequest, 'update');

        if($response)
            return response()->json([
                "success" => true,
                "message" => "Internship updated successfully!",
                "status" => "Ok",
            ], 200);

        return response()->json([
            "success" => false,
            "message" => "An error occurred!",
            "status" => "Error",
        ], 500);
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy($id)
    {
        $internship = Internship::where('id', $id);
        if($internship){
            $internship->delete();
            return response()->json([
                "success" => true,
                "message" => "Successfully Deleted",
                "status" => "Ok",
            ], 200);
        }

        return response()->json([
            "success" => false,
            "message" => "Internship not deleted",
            "status" => "Unprocessable Entity",
        ], 422);
    }

    /**
     * Create employee with data from internship
     * @return Response
     */
    public function approve($id)
    {
        $internship = Internship::findOrFail($id);
        $departments = Department::all();
        $positions = JobPosition::all();
        $trainings = Training::all();
        $enumoption = get_enums('users', 'education');
        $status_enum = get_enums('users', 'status');
        $gender_enum = ["F" => "Female", "M" => "Male"];
        $reason_enum = get_enums('user_experiences', 'quit_reason');
        $months = get_months();

        return view('employeemanagementmodule::internship.approve', compact('internship', 'enumoption', 'gender_enum', 'status_enum', 'reason_enum', 'trainings' , 'months'), ['departments' => $departments, 'positions' => $positions]);
    }

    /**
     * @return Response
     */
    public function loadTable()
    {
        $internships = Internship::get();

        return view('employeemanagementmodule::internship.load-table', compact('internships'));
    }

    /**
     * @param $object
     * @param $action
     * @param $data
     * @return bool
     */
    protected function applyChanges(Internship $object, $data, $type) : bool {
        try {
            if ($type === 'update')
                $object->update($data);
            else
                $object->create($data);
            return true;
        } catch (\Exception $e) {
            \Log::info($e);
            return false;
        }
    }
}
