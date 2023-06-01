<?php

namespace App\DataTables;

use App\User;
use Yajra\DataTables\Services\DataTable;

class LeavesDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables($query);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\User $model
     * @return array
     */
    public function query(User $model) : array
    {
        $data = [];

        $results = $model->with(['departments', 'jobs', 'requests' => function($query) {
            $query->where('status', 'APPROVED');
        }])->whereHas('requests')->select(['id', 'first_name', 'last_name', 'department_id','company','job_position_id'])->get();

        foreach ($results as $result){
            $dayCount = 0;
            if(count($result->requests) > 0 ){
                foreach ($result->requests as $request){
                    $dayCount += (calc_working_days($request->start_date, $request->end_date))* 60;
                    $leave_time = convertTime($dayCount);
                }
            }


            $data[] = (object)[
                "id" => isset($result->id) ? $result->id : " - " ,
                "first_name" => isset($result->first_name) ? $result->first_name : ' - ',
                "last_name" => isset($result->last_name) ? $result->last_name : ' - ',
                "department" => ($result->departments !== null) ? $result->departments->name : " - ",
                "company" => ($result->company !== null) ? $result->company : " - ",
                "job" => ($result->jobs !== null) ? $result->jobs->title : " - ",
                "days_taken" => $leave_time,
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
                    ->minifiedAjax()
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
            'department',
            'company',
            'job',
            'days_taken',
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Leaves_' . date('YmdHis');
    }
}
