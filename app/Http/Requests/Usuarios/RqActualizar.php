<?php

namespace iobom\Http\Requests\Usuarios;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;
class RqActualizar extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        Validator::extend('emailLongitud', function($attribute, $value, $parameters){
            $email_primero=explode("@",$value);
            if(strlen($email_primero[0])<6){
                return false;
            }
            return true;

        },"Tu nombre debe tener entre 6 y 30 caracteres de longitud.");
        return [
            'usuario'=>'required|exists:users,id',
            'name' => 'required|string|min:1',
            'telefono' => 'required|digits_between:6,10',
            'estado'=>'required|in:Activo,Inactivo,Dado de baja',
            'email' => 'required|string|email|max:255|emailLongitud|unique:users,email,'.$this->input('usuario'),
            'password' => 'nullable|string|min:8|confirmed',
        ];
    }
}
