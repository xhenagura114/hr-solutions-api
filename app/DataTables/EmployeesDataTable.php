<?php

namespace App\DataTables;

use App\User;
use Yajra\DataTables\Services\DataTable;

class EmployeesDataTable extends DataTable
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

        $results =  $model->with('departments', 'jobs')->get();

        foreach ($results as $result){

            $data[] = (object)[
                "index" =>'' ,
                "first_name" => isset($result->first_name) ? $result->first_name : ' - ',
                "last_name" => isset($result->last_name) ? $result->last_name : ' - ',
                "gender" => isset($result->gender) ? $result->gender : ' - ',
                "address" => isset($result->address) ? $result->address : ' - ',
                "email" => isset($result->email) ? $result->email : ' - ',
                "mobile_phone" => isset($result->mobile_phone) ? $result->mobile_phone : ' - ',
                "birthday" => isset($result->birthday) ? $result->birthday : ' - ',
                "education" => isset($result->education) ? $result->education : ' - ',
                "status" => isset($result->status) ? $result->status : ' - ',
                "contract_start" => isset($result->contract_start) ? \Carbon\Carbon::parse($result->contract_start)->format('Y-m-d') : ' - ',
                "contract_end" => isset($result->contract_end) ? \Carbon\Carbon::parse($result->contract_end)->format('Y-m-d') : ' - ',
                "department" => ($result->departments!== null) ? $result->departments->name : ' - ',
                "job" => ($result->jobs !== null) ? $result->jobs->title : ' - ',
                "company" => ($result->company !== null) ? $result->company : ' - ',
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
           'index',
            'first_name',
            'last_name',
            'gender',
            'address',
            'email',
            'mobile_phone',
            'birthday',
            'education',
            'status',
            'contract_start',
            'contract_end',
            'department',
            'job',
            'company'
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Employees_' . date('YmdHis');
    }
}
