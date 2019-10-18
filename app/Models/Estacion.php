<?php

namespace iobom\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use iobom\Models\Asistencia\Asistencia;
use iobom\User;

class Estacion extends Model
{
	protected $table="estacion";
	
    protected $fillable = [
        'nombre', 'direccion', 'latitud','longitud','creadoPor','actualizadoPor',
    ];


    
    public function personales()
    {
        return $this->hasMany(User::class);
    }


    public function vehiculos()
    {
        return $this->hasMany(Vehiculo::class);
    }


    public function asistenciasHoy()
    {
        $diaHoy=Carbon::now();
        $sumarUnDia=$diaHoy->addDays(1);
        $fechaMenor=$diaHoy->setDateTime($sumarUnDia->year,$sumarUnDia->month,$sumarUnDia->day,7,30,0,0)->toDateTimeString();
        return $this->hasMany(Asistencia::class)
        ->where('fecha',Carbon::now()->toDateString())->where('fechaFin','<=',$fechaMenor);
    }


}
