<?php


namespace App\DataTables;

use Modules\EmployeeManagementModule\Entities\Applicant;
use Yajra\DataTables\Services\DataTable;

class ApplicantsDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables($query)->addColumn('cv_path', function ($query) {
            return '<input type ="checkbox" name = "'.$query->id. '" id = "'.$query->id. '"> <a href="'.asset('/').$query->cv_path.'" target="_blank">'.$query->first_name.'\'s CV</a>';
        })
            ->rawColumns(['cv_path']);
    }
    /*** Get query source of dataTable.
     *
     * @param \App\User $model
     * @return array
     */
    public function query(Applicant $model) : array
    {
        $data = [];
        if($this->attributes['selectedSkill'] != '' || $this->attributes['selectedSeniority'] != '') {
            $results = $model->select(
                'applicants.*'
            )->join('applicant_skills', 'applicants.id', '=', 'applicant_skills.applicant_id')
                ->join('skills', 'skills.id', '=', 'applicant_skills.skill_id')
                ->where('skills.title', 'LIKE', '%' . $this->attributes['selectedSkill'] . '%')
                ->where('applicant_skills.seniority', 'LIKE', '%' . $this->attributes['selectedSeniority'] . '%')
                ->where('applicants.status', '=', 'Interview Done')
                ->get();
        }elseif($this->attributes['selectedPosition'] != '' || $this->attributes['selectedSeniorityEvaluation'] != '') {
            $results = $model->select(
                'applicants.*'
            )   ->where('applicants.seniority', 'LIKE', '%' . $this->attributes['selectedSeniorityEvaluation'] . '%')
                ->where('applicants.possible_position', 'LIKE', '%' . $this->attributes['selectedPosition'] . '%')
                ->where('applicants.status', '=', 'Interview Done')
                ->get();
        }
        else {
            $results = $model->with('jobVacancies')->get();
        }
        foreach ($results as $result){

            $data[] = (object)[
                "id" => isset($result->id) ? $result->id : ' - ' ,
                "first_name" => isset($result->first_name) ? $result->first_name : ' - ',
                "last_name" => isset($result->last_name) ? $result->last_name : ' - ',
                "email" => isset($result->email) ? $result->email : ' - ',
                "application_date" => isset($result->application_date) ? $result->application_date : ' - ',
                "economic_offer	" => isset($result->economic_offer	) ? $result->economic_offer	 : ' - ',
                "contact" => isset($result->contact) ? $result->contact : ' - ',
                "job" => ($result->jobVacancies !== null) ? $result->jobVacancies->position : ' - ',
                "status" => isset($result->status) ? $result->status : ' - ',
                "cv_path" => isset($result->cv_path) ? $result->cv_path : ' - ',
            ];
        }
        return $data;
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->columns($this->getColumns())
            ->minifiedAjax('', null, request()->only(['applicantSkillReport', 'applicantSeniorityReport', 'applicantPossiblePositionReport','applicantSeniorityEvaluationReport']))
            ->parameters([
                'dom' => 'Bfrtip',
                'searching' => true,
                'pageLength' => 14,
                'buttons' => [
                    'dom' => [
                        'button' => [
                            'className' => ''
                        ]
                    ],
                    'buttons' => [
                        [
                            'extend' => 'excel',
                            'className' => 'btn btn-success ml-3 mr-2 mb-3',
                            'text' => '<i class="fa fa-file-excel-o mr-3"></i> Exel'
                        ],
                        [
                            'extend' => 'csv',
                            'className' => 'btn btn-info mr-2 mb-3',
                            'text' => '<i class="fa fa-file-text mr-3"></i> CSV'
                        ],
                        [
                            'extend' => 'print',
                            'className' => 'btn btn-primary mb-3',
                            'text' => '<i class="fa fa-print mr-3"></i> Print'
                        ],
                    ]
                ]
            ]);
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            'id',
            'first_name',
            'last_name',
            'email',
            'contact',
            'application_date',
            'economic_offer	',
            'job',
            'status',
            'cv_path'
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Applicants_' . date('YmdHis');
    }
}