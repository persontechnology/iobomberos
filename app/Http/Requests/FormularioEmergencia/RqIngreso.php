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
            "vehiculos"    => "required|array",
            "vehiculos.*"  => "required|exists:asistencia_vehiculos,id",
            "operador"    => "required|array",
            "operador.*"  => "required|exists:asistencia_personals,id",
            "operativos"    => "required|array",
            "operativos.*"  => "required|exists:asistencia_personals,id",
            'emergencia'=>'required|exists:emergencia,id',
            'puntoReferencia'=>'nullable|exists:puntoReferencia,id',
            'direcionAdicional'=>'nullable|string|max:255',
            'telefono'=>'nullable|digits_between:1,6',
            'encargadoFormulario'=>'required|exists:asistencia_personals,id'
        ];
    }
}
