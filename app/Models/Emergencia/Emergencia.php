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
    public function formulariosEstadisticasAnio($id,$fecha,$mes)
    {
        $anio=date('Y',strtotime($fecha));
  
        $formulario=FormularioEmergencia::where('emergencia_id',$id)
        ->whereYear('fecha',$anio)
        ->whereMonth('fecha',$mes)
        ->where('estado','Finalizado')
        ->count();
        return $formulario;

        
    }
    public function formulariosEstadisticas($id,$fecha)
    {
        $anio=date('Y',strtotime($fecha));
        $mes=date('n',strtotime($fecha));
        $formulario=FormularioEmergencia::where('emergencia_id',$id)
        ->whereYear('fecha',$anio)
        ->whereMonth('fecha',$mes)
        ->where('estado','Finalizado')
        ->count();
        return $formulario;

        
    }
    public function formulariosEstadisticasMas($id,$fecha)
    {
        $anio=date('Y',strtotime($fecha));
        $mes=date('n',strtotime($fecha));
        
       return $formulario=FormularioEmergencia::where('emergencia_id',$id)
        ->whereYear('fecha',$anio)
        ->whereMonth('fecha',$mes)
        ->where('estado','Finalizado ')
        ->count();

        
    }

    public function formularioPastel($id,$fecha)
    {
        $anio=date('Y',strtotime($fecha));
         $formularios=FormularioEmergencia::whereYear('fecha',$anio)
         ->where('estado','Finalizado')
         ->count();
          $misformularios=FormularioEmergencia::where('emergencia_id',$id)
        ->whereYear('fecha',$anio)
        ->where('estado','Finalizado')
        ->count();
        if($formularios>0){
            return $operacion=number_format((($misformularios*100)/$formularios),2);
        }else{
            return 0;
        }
    }

    public function formularioPastelMes($id,$fecha)
    {
        $anio=date('Y',strtotime($fecha));
        $mes=date('n',strtotime($fecha));
         $formularios=FormularioEmergencia::whereYear('fecha',$anio)
         ->where('estado','Finalizado')
         ->whereMonth('fecha',$mes)
         ->count();
          $misformularios=FormularioEmergencia::where('emergencia_id',$id)
        ->whereYear('fecha',$anio)
        ->whereMonth('fecha',$mes)
        ->where('estado','Finalizado')
        ->count();
        if($formularios>0){
            return $operacion=number_format((($misformularios*100)/$formularios),2);
        }else{
            return 0;
        }
    }
}
