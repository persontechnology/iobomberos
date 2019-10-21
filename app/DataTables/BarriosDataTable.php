<?php

namespace iobom\DataTables;

use Yajra\DataTables\Services\DataTable;
use iobom\Models\Barrio;

class BarriosDataTable extends DataTable
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
            ->editColumn('parroquia_id',function($pr){
                return $pr->parroquia->nombre;
            })
            ->filterColumn('parroquia_id',function($query, $keyword){
                $query->whereHas('parroquia', function($query) use ($keyword) {
                    $query->whereRaw("nombre like ?", ["%{$keyword}%"]);
                });            
            })
            ->addColumn('action', function($barrio){
                return view('barrios.acciones',['barrio'=>$barrio])->render();
        });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \iobom\User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Barrio $model)
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
            'parroquia_id',
          
        ];
    }
     protected function getColumnsTable()
    {
        return [
           
            'parroquia_id'=>['title'=>'Parroquia'],
            'nombre',
            'codigo',
                     
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Barrios_' . date('YmdHis');
    }
}
