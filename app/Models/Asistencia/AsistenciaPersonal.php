<?php

namespace iobom\Models\Asistencia;

use Illuminate\Database\Eloquent\Model;
use iobom\User;

class AsistenciaPersonal extends Model
{
    public function asistencia()
    {
        return $this->belongsTo(Asistencia::class, 'asistencia_id');
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
