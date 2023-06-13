<?php

namespace App\Http\Requests\Domain\StoreType;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreTypeUpdateRequest extends FormRequest
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
            'description' => ['required', 'max:255', Rule::unique('store_types')->ignore($this->route()->storeType)]
        ];
    }

    public function messages(): array
    {
        return [
            'description.required' => 'O campo descrição é obrigatório!',
            'description.max' => 'O campo descrição deve ter no máximo 255 caracteres!',
            'description.unique' => 'Descrição já cadastrado, por favor verificar!'
        ];
    }
}
