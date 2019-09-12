<?php

namespace iobom\DataTables;

use Yajra\DataTables\Services\DataTable;
use iobom\Models\Estacion;

class EstacionDataTable extends DataTable
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
            ->editColumn('foto',function($est){
                return view('estaciones.foto',['est'=>$est])->render();
            })
            ->addColumn('action', function($estacion){
                return view('estaciones.acciones',['estacion'=>$estacion])->render();
        })->rawColumns(['foto','action']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \iobom\User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Estacion $model)
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
            'direccion',
            'foto'
            
        ];
    }
     protected function getColumnsTable()
    {
        return [
           'foto',
            'nombre',
            'direccion'=>['title'=>'Dirección'],            
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Estacion_' . date('YmdHis');
    }
}
