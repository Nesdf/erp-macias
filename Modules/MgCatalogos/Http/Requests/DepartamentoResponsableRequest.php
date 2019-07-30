<?php

namespace Modules\MgCatalogos\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DepartamentoResponsableRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
            'nombre' => 'required|max:50|regex:/^[a-záéíóúñA-ZÁÉÍÓÚÑ0-9 ]+$/',
            'descripcion' =>'nullable|regex:/^[a-záéíóúñA-ZÁÉÍÓÚÑ0-9 ]+$/'
        ];
    }

    public function messages()
    {
        return [
            'nombre.required' => 'El nombre es requerido',
            'nombre.max' => 'El nombre excede los 50 caracteres',
            'nombre.regex' => 'El nombre contiene caracteres incorrectos',
            'descripcion.regex' => 'EL campo descripción contiene caracteres incorrectos'
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
