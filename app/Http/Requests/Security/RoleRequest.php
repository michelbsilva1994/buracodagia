<?php

namespace App\Http\Requests\Security;

use Illuminate\Foundation\Http\FormRequest;

class RoleRequest extends FormRequest
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
            'name' => 'unique:roles|required|min:5'
        ];
    }

    public function messages(): array
    {
        return[
            'name.unique' => 'Nome já utilizado, por favor informar um novo nome de perfil!',
            'name.required' => 'O campo Perfil é obrigatório!',
            'name.min' => 'O nome deve conter no mínimo 5 caracteres!'
        ];
    }
}
