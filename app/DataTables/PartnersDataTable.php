<?php


namespace App\DataTables;

use Modules\EmployeeManagementModule\Entities\Partner;
use Yajra\DataTables\Services\DataTable;

class PartnersDataTable extends DataTable
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
    /*** Get query source of dataTable.
     *
     * @param \App\User $model
     * @return array
     */
    public function query(Partner $model) : array
    {
        $data = [];

        $results =  $model->get();

        foreach ($results as $result){

            $data[] = (object)[
                "id" =>'' ,
                "first_name" => isset($result->first_name) ? $result->first_name : ' - ',
                "last_name" => isset($result->last_name) ? $result->last_name : ' - ',
                "birthday" => isset($result->birthday) ? $result->birthday : ' - ',
                "contact" => isset($result->contact) ? $result->contact : ' - ',
                "company" => isset($result->company) ? $result->company : ' - ',
                "job_position" => isset($result->job_position) ? $result->job_position : ' - ',
                "email" => isset($result->email) ? $result->email : ' - ',
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
            ->addIndex()
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->parameters([
                'dom' => 'Bfrtip',
                // 'searching' => true,
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
                'order'=> [7,'asc'],
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
            'contact',
            'company',
            'job_position',
            'email',
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Partners_' . date('YmdHis');
    }
}