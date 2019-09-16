<?php

namespace iobom\Imports;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use iobom\Models\Estacion;
use iobom\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Spatie\Permission\Models\Role;

class UsersImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $user=User::where('email',$row[1])->first();
        
        $est=Estacion::where('nombre','Latacunga')->first();

        if(!$user){
            $user= new User();
            $user->name= $row[0];
            $user->email= $row[1]; 
            $user->password= Hash::make(Str::random(8));
            $user->telefono=$row[2];
            $user->estacion_id=$est->id;
            $user->save();
            $rol=Role::where('name',$row[3])->first();
            if($rol){
                $user->assignRole($rol);
            }
        }
    
        return $user;
    }
}
