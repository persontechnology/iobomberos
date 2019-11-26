<?php

namespace iobom\Models;

use Illuminate\Database\Eloquent\Model;
use iobom\Models\Emergencia\Emergencia;
use iobom\Models\FormularioEmergencia\Edificacion;
use iobom\Models\FormularioEmergencia\EstacionFormularioEmergencia;
use iobom\Models\FormularioEmergencia\EtapaIncendio;
use iobom\Models\PuntoReferencia;
use iobom\User;

class FormularioEmergencia extends Model
{
    protected $table="formularioEmergencia";


    // A:Derivid
    // D: un formulario tiene una emergencia
    public function emergencia()
    {
        return $this->belongsTo(Emergencia::class, 'emergencia_id');
    }

    public function puntoReferencia()
    {
        return $this->belongsTo(PuntoReferencia::class, 'puntoReferencia_id');
    }



    // A:Deivid
    // D: un formulario tiene una maxima autoridad axinado
    public function maximaAutoridad()
    {
        return $this->belongsTo(User::class,'maximaAutoridad_id');
    }


    // A:Deivid
    // D: un formulario tiene un usuario responsable, quien creao el formulario
    public function responsable()
    {
        return $this->belongsTo(User::class,'creadoPor');
    }


    // A:Deivid
    // D:un formualrio tiene varias estaciones asignadas
    public function estaciones()
    {
        return $this->belongsToMany(Estacion::class, 'estacion_formulario_emergencias', 'formularioEmergencia_id', 'estacion_id')
        ->as('estacionFormulario')
        ->withPivot(['id','estacion_id','formularioEmergencia_id']);
    }

    // A:fabian
    // D:un formualrio una etapa de incendio
    public function etapaIncendio()
    {
        return $this->hasOne(EtapaIncendio::class,'formularioEmergencia_id');
    }

    // A:fabian
    // D:un formualrio tiene una edificacion
    public function edificacion()
    {
        return $this->hasOne(Edificacion::class,'formularioEmergencia_id');
    }

    public function estacionFormularioEmergencias()
    {
        return $this->hasMany(EstacionFormularioEmergencia::class,'formularioEmergencia_id');
    }
}
