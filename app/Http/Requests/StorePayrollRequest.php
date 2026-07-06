<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePayrollRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'employee_id' => 'required|exists:employees,id',
            'month' => 'required|string|max:255',
            'basic_salary' => 'required|numeric|min:0',
            'allowances' => 'nullable|numeric|min:0',
            'bonus' => 'nullable|numeric|min:0',
            'overtime' => 'nullable|numeric|min:0',
            'net_salary' => 'required|numeric|min:0',
            'remarks' => 'nullable|string',
        ];
    }
}
