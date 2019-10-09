<?php

namespace iobom\DataTables\Formularios;

use iobom\Models\FormularioEmergencia;
use iobom\User;
use Yajra\DataTables\Services\DataTable;

class FormularioEmergenciasDataTable extends DataTable
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
            ->addColumn('action', 'formularios/formularioemergencias.action');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \iobom\User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(FormularioEmergencia $model)
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
                    ->addAction(['width' => '80px','printable' => false, 'exportable' => false,'title'=>'Acciones'])
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
            'numero',
            'fecha',
            'puntoReferencia_id',
            'emergencia_id',
            'tipoEmergencia_id'
        ];
    }
    protected function getColumnsTable()
    {
        return [            
            'numero'=>['title'=>'Número'],
            'fecha',
            'puntoReferencia_id'=>['title'=>'Lugar'],
            'emergencia_id'=>['title'=>'Emergencia'],
            'tipoEmergencia_id'=>['title'=>'Tipo Emergencia'],           
        ];
    }
    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Formularios/FormularioEmergencias_' . date('YmdHis');
    }
}
