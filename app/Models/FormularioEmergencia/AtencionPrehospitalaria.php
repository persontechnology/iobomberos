<?php

namespace iobom\Models\FormularioEmergencia;

use Illuminate\Database\Eloquent\Model;
use iobom\Models\Descargo\Medicamento;
use iobom\Models\FormularioEmergencia;

class AtencionPrehospitalaria extends Model
{
    public function formulario()
    {
        return $this->belongsTo(FormularioEmergencia::class,'formularioEmergencia_id');
    }


    public function medicamentos()
    {
        return $this->belongsToMany(Medicamento::class, 'atencion_insumos', 'atencionPrehos_id', 'medicamento_id')
        ->withPivot(['id','cantidad'])
        ->as('atencion_insumos');
    }
}
