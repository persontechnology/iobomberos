<?php

namespace iobom\Models\FormularioEmergencia;

use Illuminate\Database\Eloquent\Model;
use iobom\Models\Asistencia\AsistenciaVehiculo;
use iobom\Models\FormularioEmergencia\VehiculoOperador;
use iobom\Models\FormularioEmergencia\VehiculoOperativo;
use iobom\Models\FormularioEmergencia\VehiculoParamedico;
class FormularioEstacionVehiculo extends Model
{
    public function asistenciaVehiculo()
    {
        return $this->belongsTo(AsistenciaVehiculo::class,'asistenciaVehiculo_id');
    }
    public function vehiculoOperador()
    {
        return $this->hasOne(VehiculoOperador::class,'estacionForVehiculo_id');
    }
    public function vehiculoOperativos()
    {
        return $this->hasMany(VehiculoOperativo::class,'estacionForVehiculo_id');
    }
    public function vehiculoParamedico()
    {
        return $this->hasOne(VehiculoParamedico::class,'estacionForVehiculo_id');
    }
}
