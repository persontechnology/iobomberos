<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(EsatcionesSeeder::class);
        $this->call(RolesTableSeeder::class);
        $this->call(PermisosTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(EmergenciaTableSeeder::class);
        $this->call(TipoEmergenciaTableSeeder::class);
    }
}
