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
            ->editColumn('emergencia_id',function($pr){
                return $pr->emergencia->nombre;
            })
            ->filterColumn('emergencia_id',function($query, $keyword){
                $query->whereHas('emergencia', function($query) use ($keyword) {
                    $query->whereRaw("nombre like ?", ["%{$keyword}%"]);
                });            
            })
            ->editColumn('puntoReferencia_id',function($pr){
                if($pr->puntoReferencia){
                    return $pr->puntoReferencia->barrio->nombre.' ' .$pr->puntoReferencia->referencia;
                }else{
                    return $pr->localidad;
                }
                
            })

            ->editColumn('encardadoFicha_id',function($pr){
                return $pr->asitenciaEncardado->usuario->name??'';
            })

            ->filterColumn('encardadoFicha_id',function($query, $keyword){
                $query->whereHas('asitenciaEncardado', function($query) use ($keyword) {
                    $query->whereHas('usuario', function($query) use ($keyword) {
                        $query->whereRaw("name like ?", ["%{$keyword}%"]);
                    });
                });
            })
            
            ->filterColumn('puntoReferencia_id',function($query, $keyword){
                $query->whereHas('puntoReferencia', function($query) use ($keyword) {
                    $query->whereRaw("referencia like ?", ["%{$keyword}%"]);
                });            
            })
            
            ->addColumn('action', function($modelo){
                return view('formularios.formulariosEmergencias.acciones',['formulario'=>$modelo])->render();
            })
              ->rawColumns(['action']);
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
            'estado',
            'encardadoFicha_id',
            'localidad',
            'creadoPor',
            'heridos'
        ];
    }
    protected function getColumnsTable()
    {
        return [            
            'numero'=>['title'=>'Número'],
            'fecha',
            'puntoReferencia_id'=>['title'=>'Lugar'],
            'emergencia_id'=>['title'=>'Emergencia'],
            'encardadoFicha_id'=>['title'=>'Encargado del formulario'],
            'estado'=>['title'=>'Estado'],   
            
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
