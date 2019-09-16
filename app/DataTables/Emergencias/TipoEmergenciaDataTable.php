<?php

namespace iobom\DataTables\Emergencias;

use iobom\Models\Emergencia\TipoEmergencia;
use Yajra\DataTables\Services\DataTable;

class TipoEmergenciaDataTable extends DataTable
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
            ->addColumn('action', function($teme){
                return view('emergencias.tipo.acciones',compact('teme'))->render();
            });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \iobom\User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(TipoEmergencia $model)
    {
        
        return $model->where('emergencia_id',$this->id)->select('id', 'nombre');
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
            'nombre',
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'TipoEmergencia_' . date('YmdHis');
    }
}
