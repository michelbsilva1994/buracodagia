<?php

namespace App\Http\Requests\Contract;

use Illuminate\Foundation\Http\FormRequest;

class ContractStoreRequest extends FormRequest
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
            'id_store' => ['required'],
            'store_price' => ['required']
        ];
    }

    public function messages(): array {
        return [
            'id_store' => 'O campo loja é obrigatório!',
            'store_price' => 'O campo valor é obrigatório!',
        ];
    }
}
