<?php

namespace iobom\Http\Requests\Estaciones;

use Illuminate\Foundation\Http\FormRequest;

class RqEditar extends FormRequest
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
            'nombre'=>'required|string|max:255|unique:estacion,nombre,'.$this->input('estacion'),
            'direccion'=>'string|max:255',
            'latitud'=>'max:255',
            'longitud'=>'max:255',            
        ];
    }
}
