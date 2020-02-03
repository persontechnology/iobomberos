<?php

namespace iobom\Models\Emergencia;

use Illuminate\Database\Eloquent\Model;
use iobom\Models\FormularioEmergencia;

class TipoEmergencia extends Model
{
    
    protected $table='tipoEmergencia';
    
    protected $fillable = [
        'id',
        'nombre',
        'emergencia_id',
        'creadoPor',
        'actualizadoPor',
    ];

    public function emergencia()
    {
        return $this->belongsTo(Emergencia::class, 'emergencia_id');
    }
    public function formulariosEstadisticasTipos($id,$fecha)
    {
        $anio=date('Y',strtotime($fecha));
        $mes=date('m',strtotime($fecha));        
        $formulario=FormularioEmergencia::where('tipoEmergencia_id',$id)
        ->whereYear('fecha',$anio)
        ->whereMonth('fecha',$mes)
        ->where('estado','Finalizado')
        ->count();
        return  $formulario;

        
    }
    public function formulariosEstadisticasTiposPastel($id,$fecha,$cont)
    {
        $anio=date('Y',strtotime($fecha));
        $mes=date('m',strtotime($fecha));
        $formularios=FormularioEmergencia::where('tipoEmergencia_id',$id)
        ->whereYear('fecha',$anio)
        ->whereMonth('fecha',$mes)
        ->where('estado','Finalizado')
        ->count();        
        
        if($formularios>0){
            return $operacion=number_format((($formularios*100)/$cont),2);
        }else{
            return 0;
        }

        
    }
}
