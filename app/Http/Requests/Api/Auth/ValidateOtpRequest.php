<?php

namespace App\Http\Requests\Api\Auth;

use Illuminate\Foundation\Http\FormRequest;

class ValidateOtpRequest extends FormRequest
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
            'phone_number' => 'required|size:4',
            'mobile' => ['required', 'regex:/(0)([ ]|-|[()]){0,2}9[0-9]([ ]|-|[()]){0,2}(?:[0-9]([ ]|-|[()]){0,2}){8}/', 'digits:11']
        ];
    }

    public function prepareForValidation()
    {
        $this->merge([
            'code' => toEnglishNumbers($this->input('code') ?? ''),
            'phone_number' => toEnglishNumbers($this->input('phone_number') ?? '')
        ]);

        $this->merge([
            'phone_number' => correctPhoneNumber($this->input('phone_number') ?? '')
        ]);
    }
}
