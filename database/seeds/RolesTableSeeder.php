<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $roles = array(
            'Administrador',
            'Máxima autoridad',
            'Jefe de operaciones',
            'Oficial de guardía',
            'Clase de guardía',
            'Operador',
            'Operativos',
            'Logística',
            'Recursos humanos',
            'Radio operador',
            'Radio despachador',
            'Paramédico',
            'Inspector',
        );
        foreach ($roles as $rol) {
            Role::firstOrCreate(['name' => $rol]);
        }
    }
}
