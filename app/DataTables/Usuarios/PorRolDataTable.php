<?php

namespace iobom\DataTables\Usuarios;

use iobom\User;
use Yajra\DataTables\Services\DataTable;
use Illuminate\Support\Facades\Auth;
class PorRolDataTable extends DataTable
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
        ->addColumn('roles',function($user){
            return view('usuario.usuarios.roles',['user'=>$user])->render();
        })
        ->addColumn('action', function($user){
            return view('usuario.usuarios.acciones',['user'=>$user])->render();
        });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \cactu\User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(User $model)
    {
        return $model->role($this->rol)->where('id','!=',Auth::user()->id)->select($this->getColumns());
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

    protected function getColumns()
    {
        return [
            'id',
            'name',
            'email'
        ];
    }


    protected function getColumnsTable()
    {
        return [
            'name'=>['title'=>'Usuario'],
            'email',
            'roles'
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Usuarios/PorRol_' . date('YmdHis');
    }
}
