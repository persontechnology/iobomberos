<?php

namespace iobom\DataTables\Descargos;

use iobom\Models\Descargo\Medicamento;
use Yajra\DataTables\Services\DataTable;

class MedicamentoDataTable extends DataTable
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
            ->addColumn('action', function($medi){
                return view('descargo.medicamentos.accion',['medi'=>$medi])->render();
            });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \iobom\User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Medicamento $model)
    {
        $insumo=$this->insumo;
        $model=$insumo->medicamentos();
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
            'nombre'
        ];
    }

    protected function getColumnsTable()
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
        return 'Descargos_Medicamento_' . date('YmdHis');
    }
}
