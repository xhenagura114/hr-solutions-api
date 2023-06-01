<?php

namespace Modules\ReportsModule\Http\Controllers;

use App\DataTables\ApplicantsDataTable;
use App\DataTables\ContractsDataTable;
use App\DataTables\EmployeesDataTable;
use App\DataTables\InterviewsDataTable;
use App\DataTables\LeavesDataTable;
use App\DataTables\PartnersDataTable;
use App\DataTables\TerminationsDataTable;
use App\DataTables\TrainingsDataTable;
use App\Http\Controllers\Controller;
use App\User;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Modules\EmployeeManagementModule\Entities\Applicant;
use Modules\EmployeeManagementModule\Entities\Partner;
use Modules\EmployeeManagementModule\Entities\Skill;
use Modules\SelfServiceModule\Entities\RequestDays;
use Modules\SystemSettingsModule\Entities\Department;
use Modules\SystemSettingsModule\Entities\JobPosition;
use Modules\SystemSettingsModule\Entities\JobVacancy;

class ReportsModuleController extends Controller
{
    /**
     * Display a listing of the resource.
     * @param EmployeesDataTable $dataTable
     * @return Response
     */
    public function index(EmployeesDataTable $dataTable)
    {
        $departments = Department::distinct()->get(['name']);
        $company_enum = get_enums('users', 'company');
        $gender_enum = ["F" => "F", "Male" => "M"];
        $result = User::select(DB::raw('YEAR(contract_start) as year'))->distinct()->orderBy('year','ASC')->get();
        $contract_start_year = $result->pluck('year');
        return $dataTable->render("reportsmodule::index", compact('company_enum', 'departments', 'gender_enum', 'contract_start_year'));
    }


    public function contracts($type)
    {
        $dataTable = new ContractsDataTable($type);
        return $dataTable->render("reportsmodule::index");
    }

    public function terminations(TerminationsDataTable $dataTable)
    {
        return $dataTable->render('reportsmodule::index');
    }

    public function leaves(LeavesDataTable $dataTable)
    {
        $companies = get_enums('users', 'company');

        return $dataTable->render("reportsmodule::index", compact('companies'));
    }

    public function trainings(TrainingsDataTable $dataTable)
    {
        return $dataTable->render("reportsmodule::index");
    }

    public function partners(PartnersDataTable $dataTable)
    {
        
        return $dataTable->render("reportsmodule::partners");
        
    }

    public function interviews(InterviewsDataTable $dataTable, Request $request)
    {
        $applicantSkill = isset($_GET['applicantSkillReport']) && $_GET['applicantSkillReport'] != '*' ? $_GET['applicantSkillReport'] : '';
        $applicantSeniority = isset($_GET['applicantSeniorityReport']) && $_GET['applicantSeniorityReport'] != '*' ? $_GET['applicantSeniorityReport'] : '';
        $applicantPosition = isset($_GET['applicantPossiblePositionReport']) && $_GET['applicantPossiblePositionReport'] != '*' ? $_GET['applicantPossiblePositionReport'] : '';
        $applicantSeniorityEvaluation = isset($_GET['applicantSeniorityEvaluationReport']) && $_GET['applicantSeniorityEvaluationReport'] != '*' ? $_GET['applicantSeniorityEvaluationReport'] : '';
        $job_vacancies_all = JobVacancy::get();
        $job_vacancies = Applicant::with('jobVacancies')->distinct()->get(['job_vacancy_id']);
        $skills = Skill::get();
        $applicant_position = Applicant::distinct()->get(['possible_position']);
        $applicant_seniority = Applicant::distinct()->get(['seniority']);
        $seniority = get_enums('applicant_skills', 'seniority');
        return $dataTable->with(['selectedSkill' => $applicantSkill, 'selectedSeniority' => $applicantSeniority, 'selectedPosition'=> $applicantPosition, 'selectedSeniorityEvaluation'=>$applicantSeniorityEvaluation])->render('reportsmodule::interviews', compact('job_vacancies', 'job_vacancies_all', 'skills', 'applicant_position','applicant_seniority','seniority'));
    }

    public function applicants(ApplicantsDataTable $dataTable, Request $request)
    {
        $applicantSkill = isset($_GET['applicantSkillReport']) && $_GET['applicantSkillReport'] != '*' ? $_GET['applicantSkillReport'] : '';
        $applicantSeniority = isset($_GET['applicantSeniorityReport']) && $_GET['applicantSeniorityReport'] != '*' ? $_GET['applicantSeniorityReport'] : '';
        $applicantPosition = isset($_GET['applicantPossiblePositionReport']) && $_GET['applicantPossiblePositionReport'] != '*' ? $_GET['applicantPossiblePositionReport'] : '';
        $applicantSeniorityEvaluation = isset($_GET['applicantSeniorityEvaluationReport']) && $_GET['applicantSeniorityEvaluationReport'] != '*' ? $_GET['applicantSeniorityEvaluationReport'] : '';
        $job_vacancies_all = JobVacancy::get();
        $job_vacancies = Applicant::with('jobVacancies')->distinct()->get(['job_vacancy_id']);
        $skills = Skill::get();
        $applicant_position = Applicant::distinct()->get(['possible_position']);
        $applicant_seniority = Applicant::distinct()->get(['seniority']);
        $seniority = get_enums('applicant_skills', 'seniority');
        return $dataTable->with(['selectedSkill' => $applicantSkill, 'selectedSeniority' => $applicantSeniority, 'selectedPosition'=> $applicantPosition, 'selectedSeniorityEvaluation'=>$applicantSeniorityEvaluation])->render('reportsmodule::interviews', compact('job_vacancies', 'job_vacancies_all', 'skills', 'applicant_position','applicant_seniority','seniority'));
    }
    public function sendmail(Request $request){
        $title = $request->input('title');
        $content = $request->input('content');

        $user = User::first();

        Mail::send('email.birthday', ['user' => $user], function ($message)
        {

            $message->from('me@gmail.com', 'Christian Nwamba');

            $message->to('chrisn@scotch.io');

        });


        return response()->json(['message' => 'Request completed']);

    }
}