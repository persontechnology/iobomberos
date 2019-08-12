<?php

namespace iobom\Models\Emergencia;

use Illuminate\Database\Eloquent\Model;

class TipoEmergencia extends Model
{
    
    protected $table='tipoEmergencia';
    
    protected $fillable = [
        'nombre',
        'emergencia_id',
        'creadoPor',
        'actualizadoPor',
    ];

    public function emergencia()
    {
        return $this->belongsTo(Emergencia::class, 'emergencia_id');
    }
}
