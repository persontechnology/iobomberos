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
            'Operador',
            'Sargento',
            'Cabo',
            'Teniente',
            'Sub-Oficial',
            'Paramédico ',
        );
        foreach ($roles as $rol) {
            Role::firstOrCreate(['name' => $rol]);
        }
    }
}
