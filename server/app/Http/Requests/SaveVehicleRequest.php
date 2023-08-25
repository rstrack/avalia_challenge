<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaveVehicleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'min:3',
                'max:255'
            ],
            'brand' => [
                'required',
                'min:3',
                'max:255'
            ],
            'year' => [
                'required',
                'size:4'
            ],
            'plate' => [
                'required',
                'unique:vehicles,plate,' . $this->id,
                'regex:/([A-Za-z]{2}[A-Za-z0-9][0-9][A-Za-z0-9]{3})|([A-Za-z]{3}-?[0-9]{4})/'
            ],
            'sale_value' => [
                'required',
                'decimal:0,2'
            ],
        ];
    }

    public function messages(){
        return [
            'brand.required' => 'Marca obrigatória',
            'brand.min' => 'O campo marca deve conter no mínimo :min caracteres.',
            'brand.max' => 'O campo marca deve conter no máximo :max caracteres.',
            'plate.required' => 'Placa obrigatória.',
            'plate.unique' => 'Placa já registrada.',
            'plate.regex' => 'Placa inválida.',
            'sale_value.required' => 'Valor de venda obrigatório.',
            'sale_value.decimal' => 'O valor de venda deve ter entre :decimal casas decimais.'
        ];
    }
}
