<?php

namespace iobom\Http\Requests\FormularioEmergencia;

use Illuminate\Foundation\Http\FormRequest;

class RqIngreso extends FormRequest
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
            'institucion'=>'required|string:191',
            'formaAviso'=>'required|in:Personal,Teléfonico',
            'frecuencia'=>'required|in:Lunes-Viernes,Fin de semana,Feriado',
            'emergencia'=>'required|exists:emergencia,id',
            "estaciones"    => "required|array",
            "estaciones.*"  => "required|exists:estacion,id",
            'emergencia'=>'required|exists:emergencia,id',
            'puntoReferencia'=>'required|exists:puntoReferencia,id',
        ];
    }
}
