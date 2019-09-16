<?php

namespace iobom\Http\Requests\Vehiculo;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;
use iobom\Models\Vehiculo;

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
        Validator::extend('existeInfo', function($attribute, $value, $parameters){
 
            $validateequipo=Vehiculo::where('codigo',$value)
            ->where('id','!=',$this->input('vehiculo'))
            ->where('tipoVehiculo_id',$this->input('tipoVehiculo'))
            ->first();
            if($validateequipo){
                return false;
            }else{
                return true;
            }

        },"El codigo del vehículo ya esta registrado");

        return [
            'vehiculo'=>'required|exists:vehiculo,id',
            'estacion'=>'required|exists:estacion,id',  
            'placa'=>'required|string|max:191|unique:vehiculo,placa,'.$this->input('vehiculo'),
            'codigo'=>'required|integer|existeInfo',
            'marca'=>'required|string|max:191',
            'modelo'=>'required|string|max:191',
            'cilindraje'=>'required|string|max:191',
            'anio'=>'required|integer',
            'motor'=>'required|string|max:191|unique:vehiculo,motor,'.$this->input('vehiculo'),
        ];
    }
}
