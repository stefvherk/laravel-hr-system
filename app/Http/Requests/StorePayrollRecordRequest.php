<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StorePayrollRecordRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'employee_id' => [
                'required',
                'exists:employees,id'
            ],

            'pay_period' => [
                'required',
                'date'
            ],

            'base_salary' => [
                'required',
                'numeric',
                'min:0'
            ],

            'bonus' => [
                'nullable',
                'numeric',
                'min:0'
            ],

            'deductions' => [
                'nullable',
                'numeric',
                'min:0'
            ],
        ];
    }
}
