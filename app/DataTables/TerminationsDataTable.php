<?php

namespace App\DataTables;

use App\User;
use Yajra\DataTables\Services\DataTable;

class TerminationsDataTable extends DataTable
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

        $results =  $model->with('departments', 'jobs')->onlyTrashed()->get();

        foreach ($results as $result){

            $data[] = (object)[
                "index" =>'' ,
                "first_name" => isset($result->first_name) ? $result->first_name : ' - ',
                "last_name" => isset($result->last_name) ? $result->last_name : ' - ',
                "birthday" => isset($result->birthday) ? $result->birthday : ' - ',
                "education" => isset($result->education) ? $result->education : ' - ',
                "status" => isset($result->status) ? $result->status : ' - ',
                "contract_start" => isset($result->contract_start) ? \Carbon\Carbon::parse($result->contract_start)->format('Y-m-d') : ' - ',
                "contract_end" => isset($result->contract_end) ? \Carbon\Carbon::parse($result->contract_end)->format('Y-m-d') : ' - ',
                "department" => isset($result->departments) ? $result->departments->name : ' - ',
                "job" => ($result->jobs !== null) ? $result->jobs->title : ' - ',
                "deleted_at" => isset($result->deleted_at) ? $result->deleted_at : ' - ',
                "quit_reason" => isset($result->quit_reason) ? $result->quit_reason : ' - ',

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
                         ],
                         'order'=> [7,'desc'],
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
            'index',
            'first_name',
            'last_name',
            'birthday',
            'education',
            'status',
            'contract_start',
            'contract_end',
            'department',
            'job',
            'deleted_at',
            'quit_reason',
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Terminations_' . date('YmdHis');
    }
}
