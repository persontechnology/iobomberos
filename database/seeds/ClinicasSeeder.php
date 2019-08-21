<?php

use Illuminate\Database\Seeder;
use iobom\Models\Clinica;

class ClinicasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $clinicas = [

        	'Clínica  Continental',
			'Clínica de la Mujer',
			'Clínica el Salto',
			'Clínica Latacunga',
			'Clínica San Agustin',
			'Clínica San Francisco',
			'Clínica  Santa Cecilia',
			'Hospital General de Latacunga',
			'IESS Latacunga',
			'Provida',
			'Rehusa a ser atendido',
			'Rehusa a Transporte',
			'Sub centro Bethlemitas',
			'Sub centro Lasso',
			'Sub centro Loma Grande',
			'Sub centro Nintinacazo',
			'Sub centro San Buenaventura',
			'Sub centro Saquisilí',
			'Sub centro Tanicuchi',
        ];
        foreach ($clinicas as $nombre) {
        	 Clinica::updateOrCreate(['nombre' => $nombre]);
        }

    }
}
