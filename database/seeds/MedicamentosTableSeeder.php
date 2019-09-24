<?php

use Illuminate\Database\Seeder;
use iobom\Models\Descargo\Insumo;
use iobom\Models\Descargo\Medicamento;


class MedicamentosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Insumo::firstOrCreate(['nombre' => 'EQUIPO']);
        Insumo::firstOrCreate(['nombre' => 'MATERIAL']);
        Insumo::firstOrCreate(['nombre' => 'MEDICACIÓN']);

        $estacion=Insumo::all();

        $equi = array(
            'Vendas triangulares ',
            'Fel ',
            'Glucómetro ',
            'Bvm',
            'Frazadas',
            'Collarín Cervical',
            'Férula',
            'Dea ',
            'Termómetro',
            'Cánulas',
            'Succionador',
            'Monitor ',
            'Tensiómetro ',
            'Tijera corta todo',
            'Silla de transporte',
            'Bolsa térmica ',
            'Fonendoscopio',
            'Mascarilla Rcp',
        );

        $mater = array(
            'Guantes de látex',
            'Vendas circulares ',
            'Vendas elásticas ',
            'Gasas listas',
            'Apósitos',
            'Esparadrapo',
            'Gasas elaboradas',
            'Sábanas de camilla',
            'Curitas ',
            'Equipo venoclisis ',
            'Bata operador ',
            'Micropore ',
            'Sonda vecical ',
            'Jeringuillas',
            'Cathlones ',
            'Baja lenguas ',
            'Cotonetes ',
            'Electrodos ',
            'Mascarilla con visor ',
            'Sonda de succión ',
            'Lencetas glucómetro ',
            'Vicryl',
        );

        $medi = array(
            'Lactato ringer ',
            'Voltaren',
            'Oxigeno ',
            'Atropina',
            'Keterolaco',
            'Diclofenaco ',
            'Paracetamol ',
            'Tempra ',
            'Lidocaína ',
            'Raditidina ',
            'Cloruro sodio'
        );

        foreach ($estacion as $esta) {
            if($esta->nombre=='EQUIPO'){
                foreach ($equi as $eq) {
                    Medicamento::firstOrCreate(['nombre' => $eq,'insumo_id'=>$esta->id]);
                }
            }

            if($esta->nombre=='MATERIAL'){
                foreach ($mater as $mat) {
                    Medicamento::firstOrCreate(['nombre' => $mat,'insumo_id'=>$esta->id]);
                }
            }

            if($esta->nombre=='MEDICACIÓN'){
                foreach ($medi as $med) {
                    Medicamento::firstOrCreate(['nombre' => $med,'insumo_id'=>$esta->id]);
                }
            }
            
        }
    }
}
