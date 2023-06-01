<?php

namespace App\DataTables;

use App\User;
use Yajra\DataTables\Services\DataTable;

class TrainingsDataTable extends DataTable
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
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(User $model)
    {
        return $model->with('departments', 'jobs', 'userTrainings.departments')->whereHas('userTrainings')->get();
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
                        'searching' => false,
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
            'birthday',
            'education',
            'status',
            'contract_start',
            'contract_end',
            'departments.name',
            'jobs.title',
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Trainings_' . date('YmdHis');
    }
}
