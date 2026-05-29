<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateEmployeeRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255'],

            'email' => [
                'required',
                'email',
                'unique:users,email,'. $this->employee->user_id,
            ],

            'department_id' => ['required', 'exists:departments,id'],
            
            'position_id' => ['required', 'exists:positions,id'],

            'hire_date' => ['required', 'date'],

            'employment_status' => [
                'required',
                'in:active,inactive,on_leave'
            ],

            'role' => ['required', 'in:employee,hr_manager,admin'],
        ];
    }
}
