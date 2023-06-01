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
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpWord\PhpWord;

class InterviewsController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application|Response|\Illuminate\View\View
     */
    public function index()
    {
        $job_vacancies_all = JobVacancy::get();
        $job_vacancies = Applicant::with('jobVacancies')->distinct()->get(['job_vacancy_id']);
        $applicants = Applicant::with('jobVacancies')->where('status', 'Interview Done')->distinct()->get(['economic_offer', 'application_date']);
        $gender_enum = ["F" => "Female", "M" => "Male"];
        $statuses = get_enums('applicants', 'status');
        $skills = Skill::get();
        $skills_search = Skill::where('superCategory','=', 'developer')->where('title','!=',null)->where('title','!=','Other')->get();
        $seniority = get_enums('applicant_skills', 'seniority');
        $reason_enum = get_enums('applicant_experiences', 'quit_reason');
        $economic_response = get_enums('applicants', 'response');
        $italian = get_enums('applicants', 'italian_language');

        return view('employeemanagementmodule::interviews.index', compact('job_vacancies', 'job_vacancies_all', 'gender_enum', 'applicants', 'statuses', 'skills_search','skills', 'reason_enum','seniority', 'economic_response','italian'));
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
            'email_create'      => 'required',
            'contact_create'    => 'required',
            'gender'            => 'required',
            'status'            => 'required',
        ];
        $attributes = [
            'first_name_create' => 'firstname',
            'last_name_create'  => 'lastname',
            'email_create'      => 'email',
            'contact_create'    => 'contact',
            'docs.cv_path'      => 'cv',
            'job_position'      => 'job vacancy',
            'status'            => 'status',
        ];
        $validator = Validator::make($request->all(), $rules, [], $attributes);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $skills = $request->skills;

        $createRequest = [
            "first_name" =>  $request->first_name_create,
            "last_name" =>  $request->last_name_create,
            "job_vacancy_id" =>  $request->job_position,
            "email" =>  $request->email_create,
            "contact" =>  $request->contact_create,
            "gender" =>  $request->gender,
            "status" =>  $request->status,
            "application_date" => $request->application_date,
        ];
        if(isset($request->docs['cv_path'])){
            $docName = date("YmdHis_").$request->docs["cv_path"]->getClientOriginalName();
            $save_cv = Storage::disk("public")->putFileAs('docs', $request->docs['cv_path'], $docName);
            $createRequest["cv_path"] = $save_cv;
        }
        $applicant = new Applicant();
        $response = $this->applyChanges($applicant, $createRequest, 'create');

        if($response) {
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
        $skills = Skill::where('title','!=',Null)->get();
        $italian = get_enums('applicants', 'italian_language');
        $reason_enum = get_enums('applicant_experiences', 'quit_reason');
        $economic_response = get_enums('applicants', 'response');

        return view('employeemanagementmodule::interviews.edit', compact('job_vacancies_all', 'applicant', 'gender_enum', 'statuses', 'skills', 'italian', 'reason_enum','economic_response'));
    }

    public function dev($id)
    {
        $applicant = Applicant::findOrFail($id);
        $job_vacancies_all = JobVacancy::get();
        $gender_enum = get_enums('applicants', 'gender');
        $statuses = get_enums('applicants', 'status');
        $skills = Skill::where('superCategory', 'developer')->where('title','!=',Null)->get();
        $skillCategories = Skill::where('superCategory','=', 'developer')->where('title','=',null)->orderBy('mainCategory')->get();
        $italian = get_enums('applicants', 'italian_language');
        $reason_enum = get_enums('applicant_experiences', 'quit_reason');
        $economic_response = get_enums('applicants', 'response');

        return view('employeemanagementmodule::interviews.dev', compact('job_vacancies_all', 'applicant', 'gender_enum', 'statuses', 'skills', 'skillCategories', 'italian', 'reason_enum','economic_response'));
    }

    public function devOps($id)
    {
        $applicant = Applicant::findOrFail($id);
        $job_vacancies_all = JobVacancy::get();
        $gender_enum = get_enums('applicants', 'gender');
        $statuses = get_enums('applicants', 'status');
        $skills = Skill::where('superCategory', 'devops')->where('title','!=',Null)->get();
        $skillCategories = Skill::where('superCategory','=', 'devops')->where('title','=',null)->orderBy('mainCategory')->get();
        $italian = get_enums('applicants', 'italian_language');
        $reason_enum = get_enums('applicant_experiences', 'quit_reason');
        $economic_response = get_enums('applicants', 'response');

        return view('employeemanagementmodule::interviews.devOps', compact('job_vacancies_all', 'applicant', 'gender_enum', 'statuses', 'skills','skillCategories', 'italian', 'reason_enum','economic_response'));
    }

    public function estimation($id)
    {
        $applicant = Applicant::findOrFail($id);
        $job_vacancies_all = JobVacancy::get();
        $gender_enum = get_enums('applicants', 'gender');
        $statuses = get_enums('applicants', 'status');
        $skills = Skill::get();
        $skillCategories = Skill::where('superCategory','=', 'devops')->where('title','=',null)->orderBy('mainCategory')->get();
        $italian = get_enums('applicants', 'italian_language');
        $reason_enum = get_enums('applicant_experiences', 'quit_reason');
        $economic_response = get_enums('applicants', 'response');

        return view('employeemanagementmodule::interviews.estimation', compact('job_vacancies_all', 'applicant', 'gender_enum', 'statuses', 'skills','skillCategories', 'italian', 'reason_enum','economic_response'));
    }
    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */

    public function doc(Request $request)
    {
        $phpWord = new \PhpOffice\PhpWord\PhpWord();
        $section = $phpWord->addSection();

        $phpWord->addFontStyle('ColoredText', array('color' => '2C3539','size' => 14, 'name' => 'Calibri',  'bold' => false ));
        $phpWord->addFontStyle('boldText', array('color' => '000000','size' => 16, 'name' => 'Calibri',  'bold' => true));
        $phpWord->addFontStyle('header_bold', array('color' => '000000','size' => 18, 'name' => 'Calibri',  'bold' => true));
        $phpWord->addFontStyle('header', array('color' => '000000','size' => 15, 'name' => 'Calibri',  'bold' => false));

        $styleTable = array('borderColor'=>'ffffff', 'borderSize'=> 0, 'cellMargin'=>50);
        $styleFirstRow = array('bgColor'=>'ffffff');
        $styleCell = array( 'align' => 'right');

        $header = $section->addHeader();
        $table = $header->addTable( $styleTable, $styleFirstRow);
        $table->addRow();
        $table->addCell(4500)->addImage(asset('images/moveo-albania-logo.png'),
            array( 'align' => 'left', 'wrappingStyle' => 'square',
                'positioning' => 'absolute',
                'posHorizontalRel' => 'margin',
                'posVerticalRel' => 'line'));

        $table->addCell(4500)->addText(
            'Evaluation Form',
            'header_bold', $styleCell);
        $table->addRow();
        $table->addCell(4500)->addText(
        '(filled by staff)',
        'header', $styleCell);
        $textrun = $section->addTextRun('pStyle');

        $textrun->addTextBreak();
        $textrun->addTextBreak();
        $textrun->addTextBreak();
        $textrun->addTextBreak();
        $textrun->addTextBreak();
        $textrun->addText(htmlspecialchars('Date of Interview: ',ENT_COMPAT, 'UTF-8'), 'boldText');
        $textrun->addText(htmlspecialchars($request->input('user.interview_date'),ENT_COMPAT, 'UTF-8'), 'ColoredText');
        $textrun->addTextBreak();
        $textrun->addTextBreak();
        $textrun->addText(htmlspecialchars('Name of Candidate: ',ENT_COMPAT, 'UTF-8'), 'boldText');
        $textrun->addText(htmlspecialchars($request->input('user.first_name').' '.$request->input('user.last_name'),ENT_COMPAT, 'UTF-8'), 'ColoredText');
        $textrun->addTextBreak();
        $textrun->addTextBreak();
        $textrun->addText(htmlspecialchars('Possible Position: ',ENT_COMPAT, 'UTF-8'), 'boldText');
        $textrun->addText(htmlspecialchars($request->input('user.possible_position'), ENT_COMPAT, 'UTF-8'), 'ColoredText');
        $textrun->addTextBreak();
        $textrun->addTextBreak();
        $textrun->addText(htmlspecialchars('Seniority: ',ENT_COMPAT, 'UTF-8'), 'boldText');
        $textrun->addText(htmlspecialchars($request->input('user.seniority'), ENT_COMPAT, 'UTF-8'), 'ColoredText');
        $textrun->addTextBreak();
        $textrun->addTextBreak();
        $textrun->addText(htmlspecialchars('Price:  ',ENT_COMPAT, 'UTF-8'), 'boldText');
        $textrun->addText(htmlspecialchars($request->input('user.economic_offer'), ENT_COMPAT, 'UTF-8'), 'ColoredText');
        $textrun->addTextBreak();
        $textrun->addTextBreak();
        $textrun->addText(htmlspecialchars('Foreign Languages:  ',ENT_COMPAT, 'UTF-8'), 'boldText');
        $textrun->addText(htmlspecialchars($request->input('user.languages'), ENT_COMPAT, 'UTF-8'), 'ColoredText');
        $textrun->addTextBreak();
        $textrun->addTextBreak();
        $textrun->addText(htmlspecialchars('Other (soft skills):  ',ENT_COMPAT, 'UTF-8'), 'boldText');
        $textrun->addText(htmlspecialchars($request->input('user.soft_skills'), ENT_COMPAT, 'UTF-8'), 'ColoredText');
        $textrun->addTextBreak();
        $textrun->addTextBreak();
        $textrun->addText(htmlspecialchars('Description of Technical Evaluation:  ',ENT_COMPAT, 'UTF-8'), 'boldText');
        $textrun->addText(htmlspecialchars($request->input('user.technical_evaluation'), ENT_COMPAT, 'UTF-8'), 'ColoredText');

        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
        $objWriter->save('Evaluation.docx');
        //dump($request);die;
        return response()->download(public_path('Evaluation.docx'));
    }

    public function update(Request $request, $id)
    {
        $rules = [];
        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()){
            return response()->json($validator->errors(), 200);
        }

        $save_cv = null;
        $save_scan= null;
        $user = Applicant::findOrFail($id);

        if(isset($request->user['cv_path'])){
            $docName = date("YmdHis_").$request->user["cv_path"]->getClientOriginalName();
            $save_cv = Storage::disk("public")->putFileAs('docs', $request->user['cv_path'], $docName);
        }

        if(isset($request->user['form_path'])){
            $scanName = date("YmdHis_").$request->user["form_path"]->getClientOriginalName();
            $save_scan = Storage::disk("public")->putFileAs('docs', $request->user['form_path'], $scanName);
        }
        $skills = $request->skills_edit;
        $professionalExperience = $request->experience;

        if ($request->preliminary_form_interview){
           $user->skills()->detach();
       }
        if ($skills != null) {
            foreach ($skills as $key => $skill) {
                $user->skills()->attach($skill, [
                    'month_of_experience' => $request->month_of_experience[$skill][0],
                    'level' => $request->level[$skill][0],
                    'other_technology' => (isset($request->other_technology[$skill][0])!=null) ? $request->other_technology[$skill][0] : '',
                    'seniority' => $request->seniority[$skill][0]
                ]);
            }
        }
        if ($professionalExperience != null) {
            foreach ($professionalExperience as $key => $experience) {
                $user->skills()->attach($experience, [
                    'month_of_experience' => $request->month_of_experience_category[$experience][0],
                    'level' => $request->level_category[$experience][0],
                    'other_technology' => (isset($request->other_category[$experience][0])!=null) ? $request->other_category[$experience][0] : '' ,
                    'seniority' => $request->seniority_category[$experience][0]
                ]);
            }
        }
        $cv = ($save_cv !== null) ? ["cv_path" => $save_cv] : [];
        $scan = ($save_scan !== null) ? ["form_path" => $save_scan] : [];
        $createRequest = array_except($request->user, ['cv_path', 'form_path'])  + $cv + $scan;
        $response = $this->applyChanges($user, $createRequest, 'update');

        if($response)
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
        if($applicant){
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
    public function loadTable(Request $request)
    {
        $applicantSkill = $request->input('applicantSkill') ? $request->input('applicantSkill') : '';
        $applicantSeniority = $request->input('applicantSeniority') ? $request->input('applicantSeniority') : '';

        $job_vacancies_all = JobVacancy::get();
        $job_vacancies = Applicant::with('jobVacancies')->distinct()->get(['job_vacancy_id']);

        if($applicantSkill != '' || $applicantSeniority != '') {
            $applicants = Applicant::select(
                'applicants.*'
            )->join('applicant_skills', 'applicants.id', '=', 'applicant_skills.applicant_id')
                ->join('skills', 'skills.id', '=', 'applicant_skills.skill_id')
                ->where('skills.title', 'LIKE', '%' . $applicantSkill . '%')
                ->where('applicant_skills.seniority', 'LIKE', '%' . $applicantSeniority . '%')
                ->where('applicants.status', '=', 'Interview Done')
                ->get();
        }
        else {
            $applicants = Applicant::with('jobVacancies')->where('status', 'Interview Done')->get();
        }

        return view('employeemanagementmodule::interviews.load-table', compact('job_vacancies', 'job_vacancies_all', 'applicants'));
    }
    /**
     * @param Applicant $object
     * @param $data
     * @param $type
     * @return Applicant|void
     */
    protected function applyChanges(Applicant $object, $data, $type) {
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