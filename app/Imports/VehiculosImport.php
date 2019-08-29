<?php

namespace iobom\Imports;


use Maatwebsite\Excel\Concerns\ToModel;
use iobom\Models\TipoVehiculo;
use iobom\Models\Estacion;
use iobom\Models\Vehiculo;

class VehiculosImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
          $estacion=Estacion::where('nombre',$row[0])->first();
          $tipo=TipoVehiculo::where('nombre',$row[1])->first();
          $vehiculo=Vehiculo::where('placa',$row[8])->first();
        if(!$vehiculo && $tipo && $estacion){
            $vehiculo= new Vehiculo();
            $vehiculo->placa=$row[8];
            $vehiculo->codigo=$row[2];
            $vehiculo->marca=$row[3];
            $vehiculo->modelo=$row[4];
            $vehiculo->cilindraje=$row[5];
            $vehiculo->anio=$row[6];
            $vehiculo->motor=$row[7];
            $vehiculo->estacion_id=$estacion->id;
            $vehiculo->tipoVehiculo_id=$tipo->id;


        }
        return $vehiculo;
    
    }
}
