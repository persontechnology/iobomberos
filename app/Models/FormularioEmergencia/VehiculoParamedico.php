<?php

namespace iobom\Models\FormularioEmergencia;;
use iobom\Models\Asistencia\AsistenciaPersonal;
use Illuminate\Database\Eloquent\Model;

class VehiculoParamedico extends Model
{
    public function asistenciaPersonal()
    {
        return $this->belongsTo(AsistenciaPersonal::class,'asistenciaPersonal_id');
    }
}
