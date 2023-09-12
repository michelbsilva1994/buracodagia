<?php

namespace App\Http\Requests\Domain\TypePayment;

use Illuminate\Foundation\Http\FormRequest;

class TypePaymentRequest extends FormRequest
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
            'value'=>['required','max:2','unique:type_contracts'],
            'description' => ['required', 'max:255', 'unique:type_contracts']
        ];
    }

    public function messages(): array
    {
        return [
            'value.required' => 'O campo valor é obrigatório!',
            'value.max' => 'O campo valor deve ter no máximo 2 caracteres!',
            'value.unique' => 'Valor já cadastrado, por favor verificar!',
            'description.required' => 'O campo descrição é obrigatório!',
            'description.max' => 'O campo descrição deve ter no máximo 255 caracteres!',
            'description.unique' => 'Descrição já cadastrado, por favor verificar!'
        ];
    }
}
