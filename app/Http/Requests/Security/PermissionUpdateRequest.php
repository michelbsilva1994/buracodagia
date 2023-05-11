<?php

namespace App\Http\Requests\Security;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PermissionUpdateRequest extends FormRequest
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
            'name' => ['required', 'min:3', Rule::unique('permissions')->ignore($this->route()->permission)]
        ];
    }

    public function messages(): array
    {
        return [
            'name.unique' => 'Nome já utilizado, por favor informar um novo nome de permissão!',
            'name.required' => 'O campo permissão é obrigatório!',
            'name.min' => 'O nome deve conter no mínimo 5 caracteres!'
        ];
    }
}
