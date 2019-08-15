<?php

use Illuminate\Database\Seeder;
use iobom\Models\Estacion;
class EsatcionesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$estacion = ['Latacunga','Laso'];

    	$estacioncrear= Estacion::firstOrCreate([
            'nombre' => 'Latacunga',
            'latitud' => '-0.9373952061391123',
            'longitud' => '-78.61368585109557',
            
        ]);
    	$estacion= Estacion::firstOrCreate([
            'nombre' => 'Lasso',
            'latitud' => '-0.7533031329575147',
            'longitud' => '-78.61049402236785',
            
        ]);
    	
         
    }
}
