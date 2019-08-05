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
            'email' => 'appbomberoslatacunga@gmail.com',
            'password' => Hash::make('12345678'),
            'email_verified_at'=>Carbon::now()
        ]);

        $user->assignRole('Administrador');

    }
}
