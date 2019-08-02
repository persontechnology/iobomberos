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
            'Teniente',
            'Capitan',
            'Secretaria',
            'Personal de Guardia',
            'Paramedico',
            'Personal a mando',
            'Logistica',
            'Jefa de sistemas',
        );
        foreach ($roles as $rol) {
            Role::firstOrCreate(['name' => $rol]);
        }
    }
}
