<?php

namespace App\Http\Requests\Structure\Equipment;

use Illuminate\Foundation\Http\FormRequest;

class EquipmentRequest extends FormRequest
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
            'name' => ['required', 'unique:pavements']
        ];
    }

    public function messages(): array {
        return [
            'name.required' => 'O campo equipamento é obrigatório!',
            'name.unique' => 'Nome já utilizado, por favor informar um novo nome de equipamento!',
        ];
    }
}
