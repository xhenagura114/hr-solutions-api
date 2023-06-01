<?php

namespace App\DataTables;

use App\User;
use Yajra\DataTables\Services\DataTable;

class ContractsDataTable extends DataTable
{

    /**
     * @var
     */
    private $type;

    /**
     * ContractsDataTable constructor.
     * @param $type
     */
    public function __construct($type)
    {
        $this->type = $type;
    }

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
    public function query(User $model) :array
    {
        $data = [];

        if($this->type == 'year')
            $results =  $model->with('departments', 'jobs')->whereRaw('year(contract_end) = ?', array(date('Y')))->get();
        else
            $results =  $model->with('departments', 'jobs')->whereRaw('month(contract_end) = ?', array(date('m')))->get();


        foreach ($results as $result){

            $data[] = (object)[
                "id" => isset($result->id) ? $result->id : ' - ' ,
                "first_name" => isset($result->first_name) ? $result->first_name : ' - ',
                "last_name" => isset($result->last_name) ? $result->last_name : ' - ',
                "birthday" => isset($result->birthday) ? $result->birthday : ' - ',
                "education" => isset($result->education) ? $result->education : ' - ',
                "status" => isset($result->status) ? $result->status : ' - ',
                "contract_start" => isset($result->contract_start) ? $result->contract_start : ' - ',
                "contract_end" => isset($result->contract_end) ? $result->contract_end : ' - ',
                "department" => isset($result->departments) ? $result->departments->name : ' - ',
                "job" => ($result->jobs !== null) ? $result->jobs->title : ' - ',
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
            'department',
            'job'
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Contracts_' . date('YmdHis');
    }

}
