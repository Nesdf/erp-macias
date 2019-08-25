<?php

namespace Modules\MgDestino\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DestinosRequest extends FormRequest
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
            'destino' => 'required|unique:destino|max:100'
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
