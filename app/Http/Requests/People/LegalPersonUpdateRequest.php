<?php

namespace App\Http\Requests\People;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class LegalPersonUpdateRequest extends FormRequest
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
            'corporate_name' => ['required', 'max:255'],
            'fantasy_name' => ['required', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'telephone' => ['required'],
            'cnpj' => ['required', Rule::unique('legal_people')->ignore($this->route()->legalPerson)],
            'public_place' => ['required'],
            'city' => ['required'],
            'state' => ['required'],
            'nr_public_place' => ['required']
        ];
    }

    public function messages(): array
    {
        return [
            'corporate_name.required' => 'O campo razão social é obrigatório!',
            'corporate_name.max' => 'O campo razão social deve ter no máximo 255 caracteres!',
            'fantasy_name.required' => 'O campo nome fantasia é obrigatório!',
            'fantasy_name.max' => 'O campo nome fantasia deve ter no máximo 255 caracteres!',
            'email.required' => 'O campo email é obrigatório!',
            'email.email' => 'Email inválido, por favor informar um email válido!',
            'email.max' =>  'O campo email deve ter no máximo 255 caracteres!',
            'cnpj.required' => 'O campo CNPJ é obrigatório!',
            'cnpj.unique' => 'CNPJ já cadastrado, por favor verificar!',
            'cnpj.max' => 'O CNPJ deve conter no máximo 14 caracteres!',
            'telephone.required' => 'O campo telefone é obrigatório!',
            'public_place.required' => 'O campo endereço é obrigatório!',
            'city.required' => 'O campo cidade é obrigatório!',
            'state.required' => 'O campo estado é obrigatório!',
            'nr_public_place' => 'O campo Nº é obrigatório!'
        ];
    }
}
