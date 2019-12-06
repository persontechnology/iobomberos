<?php

namespace iobom\Models\Descargo;

use Illuminate\Database\Eloquent\Model;
use iobom\Models\FormularioEmergencia\AtencionInsumo;

class Medicamento extends Model
{
    public function insumo()
    {
        return $this->belongsTo(Insumo::class, 'insumo_id');
    }




    // A:DEIVID
    // D:obtner la cantidad de mediacmentos y ensumos en atencion prehospitalaria, al momento de actualizar
    public function hasAtencionInsumo($idMedicamento,$idAtencionPreHos)
    {
        $a_i=AtencionInsumo::where(['medicamento_id'=>$idMedicamento,'atencionPrehos_id'=>$idAtencionPreHos])->first();
        if($a_i){
            return $a_i->cantidad;
        }
        return '';
    }
}
