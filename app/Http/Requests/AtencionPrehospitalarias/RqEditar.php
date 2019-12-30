<?php

namespace iobom\Http\Requests\AtencionPrehospitalarias;

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
        $rg_tipo_identificacion='';
        switch ($this->input('tipo_identificacion')) {
            case 'Cédula':
                $rg_tipo_identificacion='ecuador:ci';
                break;
            case 'Ruc persona Natural':
                $rg_tipo_identificacion='ecuador:ruc';
                break;
            case 'Ruc Sociedad Pública':
                $rg_tipo_identificacion='ecuador:ruc_spub';
                break;
            case 'Ruc Sociedad Privada':
                $rg_tipo_identificacion='ecuador:ruc_spriv';
                break;
            case 'Pasaporte':
                $rg_tipo_identificacion='max:191';
                break;
            case 'Otros':
                $rg_tipo_identificacion='max:191';
                break;
        }


        return [
            'numero'=>'required|unique:atencion_prehospitalarias,numero,'.$this->input('atencion'),
            'ambulancia'=>'required|string|max:191',
            'nombres'=>'required|regex:/^[\pL\s\-]+$/u|string|max:191',
            'tipo_identificacion'=>'required|in:Cédula,Ruc persona Natural,Ruc Sociedad Pública,Ruc Sociedad Privada,Pasaporte,Otros',
            'identificacion'=>'required|string|'.$rg_tipo_identificacion,
            'edad'=>'required|integer|digits_between:1,3',
            'sexo'=>'required|string|max:191',
            'horaAtencion'=>'required|string|max:191',
            'placa'=>'nullable|string|max:191',
            'diagnostico'=>'required|string',
            'pulso'=>'required|numeric|min:1',
            'temperatura'=>'required|numeric|min:1',
            'presion'=>'required|string|max:191',
            'sp'=>'required|integer|min:1',
            'glasgow'=>'required|integer|min:1',
            'reaccionDerecha'=>'required|string|max:191',
            'dilatacionDerecha'=>'required|string|max:191',
            'reaccionIzquierda'=>'required|string|max:191',
            'dilatacionIzquierda'=>'required|string|max:191',
            // 'formulario'=>'required|exists:formularioEmergencia,id',                     
            'clinica'=>'required|integer|exists:clinica,id',
            'resposableRecibe'=>'required|string|max:191',
            'horaEntrada'=>'required|string|max:191',
            'tipoTransporte'=>'nullable|in:Transporte Innecesario,Tratamiento Rehusado,Transporte Rehusado,Ninguno',
            'motivo'=>'nullable|string|max:191',
            'nombresDescargo'=>'nullable|string|max:191|regex:/^[\pL\s\-]+$/u',
            'cedulaDescargo'=>'nullable|string|max:191',
            "cantidades"    => "nullable|array",
            "cantidades.*"  => "nullable|integer|min:0",
        ];
    }
}
