<?php

namespace iobom\DataTables;

use Yajra\DataTables\Services\DataTable;
use iobom\Models\Parroquia;

class ParroquiasDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables($query)
            ->addColumn('action', function($parroquia){
                return view('parroquias.acciones',['parroquia'=>$parroquia])->render();
        });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \iobom\User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Parroquia $model)
    {
        return $model->newQuery()->select($this->getColumns());
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
                    ->columns($this->getColumnsTable())
                    ->minifiedAjax()
                    ->addAction(['width' => '80px','exportable' => false,'printable' => false,'title'=>'Acciones'])
                    ->parameters($this->getBuilderParameters());
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
            'nombre',
            'codigo',
          
        ];
    }
     protected function getColumnsTable()
    {
        return [
           
            'nombre',
            'codigo'
                     
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Parroquias_' . date('YmdHis');
    }
}
