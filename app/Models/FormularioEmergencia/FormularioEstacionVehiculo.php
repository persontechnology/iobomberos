<?php

namespace iobom\Models\FormularioEmergencia;

use Illuminate\Database\Eloquent\Model;
use iobom\Models\Asistencia\AsistenciaVehiculo;

class FormularioEstacionVehiculo extends Model
{
    public function asistenciaVehiculo()
    {
        return $this->belongsTo(AsistenciaVehiculo::class,'asistenciaVehiculo_id');
    }
}
