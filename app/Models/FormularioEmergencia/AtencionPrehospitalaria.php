<?php

namespace iobom\Models\FormularioEmergencia;

use Illuminate\Database\Eloquent\Model;
use iobom\Models\FormularioEmergencia;

class AtencionPrehospitalaria extends Model
{
    public function formulario()
    {
        return $this->belongsTo(FormularioEmergencia::class,'formularioEmergencia_id');
    }
}
