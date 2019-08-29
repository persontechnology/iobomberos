<?php

namespace iobom\DataTables;

use iobom\Models\TipoVehiculo;
use iobom\Models\Estacion;
use iobom\Models\Vehiculo;

use Yajra\DataTables\Services\DataTable;

class VehiculosDataTable extends DataTable
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
              ->editColumn('estacion_id',function(Estacion $estacion){
                
                return $estacion->nombre;
            })
            /*->filterColumn('id',function($query, $keyword){
                $query->whereRaw("(select count(1) from actividad,modeloProgramatico where modeloProgramatico.id = actividad.modeloProgramatico_id  and CONCAT(modeloProgramatico.codigo,'',actividad.codigo) like ?) >= 1", ["%{$keyword}%"]);
            
            })*/
            ->addColumn('action', function($query){
                
            });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \iobom\User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Vehiculo $model)
    {
        return $model->where('tipoVehiculo_id',$this->id)->select($this->getColumns());
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
            'estacion_id',
            'tipoVehiculo_id',
            'placa',
            'codigo',
            'marca',
            'modelo',
            'anio',
            'motor',
            'estado',

        ];
    }

     protected function getColumnsTable()
    {
        return [
                     
            'estacion_id'=>['title'=>'Estación'],           
            'placa',
            'codigo',
            'marca',
            'modelo',
            'anio',
            'motor',
            'estado',
           
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Vehiculos_' . date('YmdHis');
    }
}
