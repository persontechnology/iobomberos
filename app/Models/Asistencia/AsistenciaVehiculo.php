<?php

namespace iobom\Models\Asistencia;

use Illuminate\Database\Eloquent\Model;
use iobom\Models\Vehiculo;

class AsistenciaVehiculo extends Model
{
    public function asistencia()
    {
        return $this->belongsTo(Asistencia::class, 'asistencia_id');
    }

    public function vehiculo()
    {
        return $this->belongsTo(Vehiculo::class, 'vehiculo_id');
    }
}
