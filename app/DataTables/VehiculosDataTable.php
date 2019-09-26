<?php

namespace iobom\DataTables;

use iobom\Models\TipoVehiculo;
use iobom\Models\Estacion;
use iobom\Models\Vehiculo;

use Yajra\DataTables\Services\DataTable;
use Illuminate\Support\Facades\Storage;

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
            ->editColumn('foto', function($modelo){
                return view('vehiculos.vehiculos.foto',['vehiculos'=>$modelo])->render();
            })
            ->editColumn('estacion_id',function(Vehiculo $vehiculo){              
                return $vehiculo->estacion->nombre;
            })
            ->filterColumn('estacion_id', function($query, $keyword) {
                $query->whereHas('estacion', function($query) use ($keyword) {
                    $query->whereRaw("nombre like ?", ["%{$keyword}%"]);
                });
            })
            ->editColumn('tipoVehiculo_id',function(Vehiculo $vehiculo){              
                return $vehiculo->tipoVehiculo->codigo.''.$vehiculo->codigo;
            })
            ->filterColumn('tipoVehiculo_id', function($query, $keyword) {
                $query->whereHas('tipoVehiculo', function($query) use ($keyword) {
                    $query->whereRaw("concat(codigo,'',vehiculo.codigo) like ?", ["%{$keyword}%"]);
                });
            })         
            
             ->addColumn('action', function($modelo){
                return view('vehiculos.vehiculos.acciones',['vehiculo'=>$modelo])->render();
            })
              ->rawColumns(['foto','action']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \iobom\User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(TipoVehiculo $model)
    {
        $idTipo=$this->idTipo;
        return $model->find($idTipo)->vehiculos()->select($this->getColumns());
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
            'foto',            
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
            'foto'=>['title'=>'Imagen','data'=>'foto'],         
            'estacion_id'=>['title'=>'Estación','data'=>'estacion_id'],           
            'placa',
            'tipoVehiculo_id'=>['title'=>'Codigo','data'=>'tipoVehiculo_id'],
            'marca',
            'modelo',
            'anio'=>['title'=>'Año'],
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
