<?php

namespace App\Http\Requests\Security;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserUpdateRequest extends FormRequest
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
            'name' => ['required', 'max:255'],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users')->ignore($this->route()->user),
            ],
            'password' => ['required'],
        ];
    }

    public function messages(): array
    {
        return [
                'name.required' => 'O campo nome é obrigatório!',
                'name.max' => 'O campo nome deve ter no máximo 255 caracteres!',
                'email.required' => 'O campo email é obrigatório!',
                'email.email' => 'Email inválido, por favor informar um email válido!',
                'email.max' =>  'O campo email deve ter no máximo 255 caracteres!',
                'email.unique' => 'Email já está sendo utilizado, por favor informar outro email!',
                'password.required' => 'O campo senha é obrigatório!'
        ];
    }
}
