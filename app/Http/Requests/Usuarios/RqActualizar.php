<?php

namespace iobom\Http\Requests\Usuarios;

use Illuminate\Foundation\Http\FormRequest;

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
        return [
            'usuario'=>'required|exists:users,id',
            'name' => 'required|string|max:1',
            'email' => 'required|string|email|max:255|unique:users,email,'.$this->input('usuario'),
            'password' => 'nullable|string|min:8|confirmed',
        ];
    }
}
