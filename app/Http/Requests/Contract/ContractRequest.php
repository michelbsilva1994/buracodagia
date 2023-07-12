<?php

namespace App\Http\Requests\Contract;

use Illuminate\Foundation\Http\FormRequest;

class ContractRequest extends FormRequest
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
            'type_person' => ['required'],
            'id_person' => ['required'],
            'type_contract' => ['required'],
            'dt_contraction' => ['required'],
            'dt_renovation' => ['required']
        ];
    }

    public function messages(): array{
        return[
            'type_person.required' => 'Escolha um tipo de pessoa!',
            'id_person.required' => 'O campo Contratante é obrigatório!',
            'type_contract.required' => 'O campo tipo de contrato é obrigatório!',
            'dt_contraction' => 'O campo data inicial do contrato é obrigatório!',
            'dt_renovation' => 'O campo data renovação do contrato é obrigatório!'
        ];
    }
}
