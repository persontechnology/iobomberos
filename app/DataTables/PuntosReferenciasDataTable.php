<?php

namespace iobom\DataTables;

use iobom\User;
use Yajra\DataTables\Services\DataTable;
use iobom\Models\PuntoReferencia;

class PuntosReferenciasDataTable extends DataTable
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
        ->editColumn('barrio_id',function($pr){
            return $pr->barrio->nombre;
        })
        ->filterColumn('barrio_id',function($query, $keyword){
            $query->whereHas('barrio', function($query) use ($keyword) {
                $query->whereRaw("nombre like ?", ["%{$keyword}%"]);
            });            
        })

        ->addColumn('parroquia',function($pr){
            return $pr->barrio->parroquia->nombre;
        })

        ->filterColumn('parroquia',function($query, $keyword){
            $query->whereHas('barrio.parroquia', function($query) use ($keyword) {
                $query->whereRaw("nombre like ?", ["%{$keyword}%"]);
            });            
        })

        ->addColumn('action', function($query){
                return view('puntosReferencias.acciones',['puntos'=>$query])->render();
        });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \iobom\User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(PuntoReferencia $model)
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
            'latitud',
            'longitud',
            'referencia',
            'barrio_id'
        ];
    }
    protected function getColumnsTable()
    {
        return [
            'referencia',
            'barrio_id'=>['title'=>'Barrio'],
            'parroquia',
            'latitud',
            'longitud',
            
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'PuntosReferencias_' . date('YmdHis');
    }
}
