<?php

namespace iobom\Models\Descargo;

use Illuminate\Database\Eloquent\Model;

class Insumo extends Model
{
    //
    public function medicamentos()
    {
        return $this->hasMany(Medicamento::class);
    }
}
