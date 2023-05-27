<?php

namespace App\Http\Requests\Structure\Srote;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
            'name' => ['required'],
            'type' => ['required'],
            'description' => ['max:255'],
            'id_pavement' => ['required']
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'O campo loja é obrigatório!',
            'type.required' => 'O campo loja é obrigatório!',
            'description.max' => 'O campo description deve ter no máximo 255 caracteres!',
            'id_pavement.required' => 'O campo pavimento é obrigatório!',
        ];
    }
}
