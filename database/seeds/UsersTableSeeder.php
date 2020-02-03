<?php

use Illuminate\Database\Seeder;
use iobom\User;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       $user= User::firstOrCreate([
            'name' => 'Bomberos',
            'email' => 'gestion.tecnologica.cbl@gmail.com',
            'estacion_id'=>1,
            'password' => Hash::make('12345678'),
            'email_verified_at'=>Carbon::now()
        ]);

        $user->assignRole('Administrador');

    }
}
