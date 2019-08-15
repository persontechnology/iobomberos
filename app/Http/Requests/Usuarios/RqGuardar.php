<?php

namespace iobom\Http\Requests\Usuarios;

use Illuminate\Foundation\Http\FormRequest;

class RqGuardar extends FormRequest
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
        return [
            'name' => 'required|string|max:191',
            'email' => 'required|string|email|max:191|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'telefono' => 'required',
            'estacion_id' => 'required',         
            "roles"    => "nullable|array",
            "roles.*"  => "nullable|exists:roles,id",
        ];
    }
}
