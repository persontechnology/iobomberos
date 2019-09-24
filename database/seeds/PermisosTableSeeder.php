<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermisosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permisos = array(
            'G. de estaciones',
            'G. de emergencias',
            'G. de personal operativos',
            'G. de clínicas',
            'G. de puntos de referencias',
            'G. de vehículos'
        );
        foreach ($permisos as $permiso) {
            Permission::firstOrCreate(['name' => $permiso]);
        }

        $role=Role::findByName('Administrador');
        $role->syncPermissions(Permission::all());

    }
}
