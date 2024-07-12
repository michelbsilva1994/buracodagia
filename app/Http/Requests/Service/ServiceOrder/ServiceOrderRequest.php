<?php

namespace App\Http\Requests\Service\ServiceOrder;

use Illuminate\Foundation\Http\FormRequest;

class ServiceOrderRequest extends FormRequest
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
            'location' => ['required'],
            'equipment' => ['required'],
            'title' => ['required'],
            'description' => ['required']
        ];
    }

    public function messages(): array {
        return [
            'location' => 'O campo localização é obrigatório!',
            'equipment' => 'O campo equipamento é obrigatório!',
            'title' => 'O campo título é obrigatório!',
            'description' => 'O campo descrição é obrigatório!',
        ];
    }
}
