<?php

namespace iobom\Models\FormularioEmergencia;

use Illuminate\Database\Eloquent\Model;
use iobom\Models\Estacion;
use iobom\Models\FormularioEmergencia;
use iobom\User;

class EstacionFormularioEmergencia extends Model
{
    protected $table="estacion_formulario_emergencias";
    public function estacion()
    {
        return $this->belongsTo(Estacion::class,'estacion_id');
    }
    public function formularioEstacionVehiculo()
    {
        return $this->hasMany(FormularioEstacionVehiculo::class,'estacionForEmergencias_id');
    }
    public function responsable()
    {
        return $this->belongsTo(User::class,'user_id');
    }
    public function formulario()
    {
        return $this->belongsTo(FormularioEmergencia::class,'formularioEmergencia_id');
    }
}
