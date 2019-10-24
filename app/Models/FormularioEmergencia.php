<?php

namespace iobom\Models;

use Illuminate\Database\Eloquent\Model;
use iobom\Models\Emergencia\Emergencia;
use iobom\Models\PuntoReferencia;
class FormularioEmergencia extends Model
{
    protected $table="formularioEmergencia";
    public function emergencia()
    {
        return $this->belongsTo(Emergencia::class, 'emergencia_id');
    }
    public function puntoReferencia()
    {
        return $this->belongsTo(PuntoReferencia::class, 'puntoReferencia_id');
    }
}
