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
    public function formulariosEstadisticas($id,$fecha,$mes)
    {
        $anio=date('Y',strtotime($fecha));
       return $formulario=FormularioEmergencia::where('emergencia_id',$id)
        ->whereYear('fecha',$anio)
        ->whereMonth('fecha',$mes)->count();

        
    }
    public function formularioPastel($id,$fecha)
    {
        $anio=date('Y',strtotime($fecha));
        $formularios=FormularioEmergencia::whereYear('fecha',$anio)->count();
        $misformularios=FormularioEmergencia::where('emergencia_id',$id)
        ->whereYear('fecha',$anio)->count();
        return $operacion=number_format((($misformularios*$formularios)/100),2);
    }
}
