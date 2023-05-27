<?php

namespace App\Http\Requests\Structure\Pavement;

use Illuminate\Foundation\Http\FormRequest;

class PavementeRequest extends FormRequest
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
            'name' => ['required', 'unique:pavements'],
            'description' => ['max:255']
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'O campo pavimento é obrigatório!',
            'name.unique' => 'Nome já utilizado, por favor informar um novo nome de pavimento!',
            'description.max' => 'O campo description deve ter no máximo 255 caracteres!'
        ];
    }
}
