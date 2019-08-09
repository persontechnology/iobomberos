<?php

namespace iobom\Models\Emergencia;

use Illuminate\Database\Eloquent\Model;

class Emergencia extends Model
{
    protected $table='emergencia';
    
    protected $fillable = [
        'nombre',
        'creadoPor',
        'actualizadoPor',
    ];
}
