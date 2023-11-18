<?php

namespace App\Http\Requests\People;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PhysicalPersonUpdateRequest extends FormRequest
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
            'name' => ['required', 'min:5'],
            //'birth_date' => ['required'],
            'email' => ['max:255'],
            'cpf' => ['required', Rule::unique('physical_people')->ignore($this->route()->physicalPerson)],
            //'rg' => [Rule::unique('physical_people')->ignore($this->route()->physicalPerson)],
            'rg' => ['max:100'],
            'telephone' => ['required'],
            //'public_place' => ['required'],
            //'city' => ['required'],
            //'state' => ['required']
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'O campo nome é obrigatório!',
            'name.min' => 'O nome deve conter no mínimo 5 caracteres!',
            //'birth_date.required' => 'O campo data nascimento é obrigatório!',
            //'email.required' => 'O campo email é obrigatório!',
            //'email.email' => 'Email inválido, por favor informar um email válido!',
            'email.max' =>  'O campo email deve ter no máximo 255 caracteres!',
            'cpf.required' => 'O campo CPF é obrigatório!',
            'cpf.unique' => 'CPF já cadastrado, por favor verificar!',
            'cpf.max' => 'O CPF deve conter no máximo 11 caracteres!',
            //'rg.required' => 'O campo RG é obrigatório!',
            //'rg.unique' => 'RG já cadastrado, por favor verificar!',
            'rg.max' => 'O nome deve conter no mínimo 100 caracteres!',
            'telephone.required' => 'O campo telefone é obrigatório!',
            //'public_place.required' => 'O campo endereço é obrigatório!',
            //'city.required' => 'O campo cidade é obrigatório!',
            //'state.required' => 'O campo estado é obrigatório!'
        ];
    }
}
