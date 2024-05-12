<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class EnderecoRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */

    public function rules(): array
    {
        return [
            'cep' => ['required', 'numeric', 'min_digits:8', 'max_digits:8'],
            'logradouro' => ['required'],
            'bairro' => ['required'],
            'municipio' => ['required'],
            'uf' => ['required','max:2', 'min:2'],
        ];
    }

    public function messages()
    {
        return [
            'cep.required' => 'Cep é requerido',
            'cep.numeric' => 'Cep deve ser númerico',
            'cep.min_digits' => 'Cep deve ter no mínimo 8 dígitos',
            'cep.max_digits' => 'Cep deve ter no máximo 8 dígitos',
            'logradouro.required' => 'Logradouro é requerido',
            'bairro.required' => 'Bairro é requerido',
            'municipio.required' => 'Municipio é requerido',
            'uf.required' => 'UF é requerido',
            'uf.max' => 'UF deve ter no máximo 2 caracteres',
            'uf.min' => 'UF deve ter no mínimo 2 caracteres',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'errors' => $validator->errors(),
        ], 422));
    }
}
