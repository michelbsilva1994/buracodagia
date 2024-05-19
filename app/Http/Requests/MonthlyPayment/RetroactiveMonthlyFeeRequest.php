<?php

namespace App\Http\Requests\MonthlyPayment;

use Illuminate\Foundation\Http\FormRequest;

class RetroactiveMonthlyFeeRequest extends FormRequest
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
            'due_date' => ['required'],
            'contract' => ['required']
        ];
    }

    public function messages(): array
    {
        return [
            'due_date.required' => 'O campo data do vencimento é obrigatório!',
            'contract.required' => 'O campo contrato é obrigatório!'
        ];
    }
}
