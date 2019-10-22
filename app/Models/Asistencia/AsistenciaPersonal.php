<?php

namespace iobom\Models\Asistencia;

use Illuminate\Database\Eloquent\Model;
use iobom\User;

class AsistenciaPersonal extends Model
{
    // asistencia generada
    public function asistencia()
    {
        return $this->belongsTo(Asistencia::class, 'asistencia_id');
    }

    // usuario registrados en la asistencia
    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
