<?php

namespace Modules\MgCatalogoTipoTrabajo\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CatalogoTipoTrabajoRequest extends FormRequest
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
            'nombre' => 'required|max:50+$/'
        ];
    }

    public function messages()
    {
        return [
            'nombre.required' => 'El nombre es requerido',
            'nombre.max' => 'El nombre excede los 50 caracteres'
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
