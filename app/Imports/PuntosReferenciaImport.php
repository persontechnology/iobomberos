<?php

namespace iobom\Imports;

use iobom\Models\Barrio;
use iobom\Models\Parroquia;
use iobom\Models\PuntoReferencia;

use Maatwebsite\Excel\Concerns\ToModel;

class PuntosReferenciaImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        
        $parroquia=Parroquia::where('nombre',$row[0])->first();
        if($parroquia){
        $barrio=Barrio::where('nombre',$row[1])
        ->where('parroquia_id',$parroquia->id)
        ->first();
         
            if($barrio){
                $punto=PuntoReferencia::where('referencia',$row[2])
                ->where('barrio_id',$barrio->id)
                ->first();
                if(!$punto){
                    $punto= new PuntoReferencia();
                    $punto->referencia=$row[2];
                    $punto->latitud=$row[3];
                    $punto->longitud=$row[4];
                    $punto->barrio_id=$barrio->id;
                    $punto->save(); 
                }           
            }else{
               $barrioNuevo=new Barrio();
               $barrioNuevo->nombre=$row[1];
               $barrioNuevo->parroquia_id=$parroquia->id;
               $barrioNuevo->codigo=$parroquia->id.'-'.$parroquia->id;
               $barrioNuevo->save();
               $punto= new PuntoReferencia();
                $punto->referencia=$row[2];
                $punto->latitud=$row[3];
                $punto->longitud=$row[4];
                $punto->barrio_id=$barrioNuevo->id;
                $punto->save(); 
            }   
        }
        return $punto;
    }
}
