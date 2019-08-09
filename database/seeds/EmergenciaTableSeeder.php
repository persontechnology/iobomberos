<?php

use Illuminate\Database\Seeder;
use iobom\Models\Emergencia\Emergencia;

class EmergenciaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = array(
            'Atencion Prehospitalaria',
            'Contra Incendio',
            'Falsa Alarma',
            'Rescate',
            'Desastres',
        );

        foreach ($data as $nombre) {
            Emergencia::firstOrCreate([
                'nombre' => $nombre,
            ]);
        }
    }
}
