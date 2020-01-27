<?php

namespace iobom\Models\Emergencia;

use Illuminate\Database\Eloquent\Model;
use iobom\Models\FormularioEmergencia;

class Emergencia extends Model
{
    protected $table='emergencia';
    
    protected $fillable = [
        'nombre',
        'creadoPor',
        'actualizadoPor',
    ];

    public function tipos()
    {
        return $this->hasMany(TipoEmergencia::class);
    }

    public function buscarFormularioTiopó()
    {
       return $this->tipos();
    }
    public function formularios()
    {
        $fecha="2020-01";
        return $this->hasMany(FormularioEmergencia::class,'emergencia_id');
    }
}
