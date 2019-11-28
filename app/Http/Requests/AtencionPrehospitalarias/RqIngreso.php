<?php

namespace iobom\Http\Requests\AtencionPrehospitalarias;

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
        'numero'=>'required|integer|min:1',
        'ambulancia'=>'required|string|max:191',
        'nombres'=>'required|regex:/^[\pL\s\-]+$/u|string|max:191',
        'cedula'=>'required|min:10',
        'edad'=>'required|integer|digits_between:1,2',
        'sexo'=>'required|string|max:191',
        'horaAtencion'=>'required|string|max:191',
        'placa'=>'nullable|string|max:191',
        'diagnostico'=>'required|string',
        'pulso'=>'required|integer|min:1',
        'temperatura'=>'required|integer|min:1',
        'presion'=>'required|string|max:191',
        'sp'=>'required|integer|min:1',
        'glasgow'=>'required|integer|min:1',
        'reaccionDerecha'=>'required|string|max:191',
        'dilatacionDerecha'=>'required|string|max:191',
        'reaccionIzquierda'=>'required|string|max:191',
        'dilatacionIzquierda'=>'required|string|max:191',
        'formulario'=>'required|exists:formularioEmergencia,id',                     
        'clinica'=>'required|integer|exists:clinica,id',
        'resposableRecibe'=>'required|string|max:191',
        'horaEntrada'=>'required|string|max:191',
        'tipoTransporte'=>'nullable|string|max:191',
        'motivo'=>'nullable|string|max:191',
        'nombresDescargo'=>'nullable|string|max:191|regex:/^[\pL\s\-]+$/u',
        'cedulaDescargo'=>'nullable|string|max:191',
        ];
    }
}
