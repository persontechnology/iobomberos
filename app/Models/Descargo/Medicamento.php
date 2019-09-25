<?php

namespace iobom\Models\Descargo;

use Illuminate\Database\Eloquent\Model;

class Medicamento extends Model
{
    public function insumo()
    {
        return $this->belongsTo(Insumo::class, 'insumo_id');
    }
}
