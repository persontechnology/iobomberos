<?php

use Illuminate\Database\Seeder;
use iobom\Models\TipoVehiculo;

class TiposVehiculosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
		        'Autobomba-B',
				'Ambulancia-A',
				'Bus-OB',
				'Camioneta-R', 
				'Furgoneta-OH',
				'Furgon-UC',
				'Jeeps-J',
				'Moto-M',
				'Tanquero-T',
		];
		foreach ($data as $nombre) {
			$tipov=explode('-', $nombre);
        	 TipoVehiculo::updateOrCreate([
        	 	'nombre' => $tipov[0],
        	 	'codigo'=>$tipov[1]
        	 ]);
        } 


    }
}
