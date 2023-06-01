<?php

namespace Modules\EmployeeManagementModule\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\EmployeeManagementModule\Entities\Skill;

class SkillsController extends EmployeeManagementModuleController
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $skills = Skill::get();
        return view('employeemanagementmodule::skills.index', compact('skills'));
    }

    /**
     * @param $id
     * @return \Illuminate\Database\Eloquent\Builder|Skill
     */
    public function searchBySkill(Request $request)
    {   

        $skill = Skill::find($request->id);
        

        $users = $skill->users;
        $applicants = $skill->applicants;

        $records = [];

        foreach ($users as $user) {
            $records[] = [
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'email' => $user->email,
                'mobile' => $user->mobile_phone,
                'skill' => $skill->title,
                'type' => 'employee'
            ];
        }

        foreach ($applicants as $applicant) {
            $records[] = [
                'first_name' => $applicant->first_name,
                'last_name' => $applicant->last_name,
                'email' => $applicant->email,
                'mobile' => $applicant->contact,
                'skill' => $skill->title,
                'type' => 'applicant'
            ];
        }

        return view('employeemanagementmodule::skills.load-table', compact('records'));
    }
}
