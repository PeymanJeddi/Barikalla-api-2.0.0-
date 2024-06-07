<?php

namespace App\Http\Requests\Api\Gateway;

use Illuminate\Foundation\Http\FormRequest;

class GatewayUpdateRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'biography' => ['required', 'max:3000'],
            'is_payment_active' => ['required', 'boolean'],
            'job_id' => ['required', 'exists:kinds,id'],
            'min_donate' => ['required', 'integer', 'min:5000'],
            'max_donate' => ['required', 'integer', 'max:100000000'],
            'is_donator_pay_wage' => ['required', 'boolean'],
            'is_donator_pay_tax' => ['required', 'boolean'], 
        ];
    }
}
