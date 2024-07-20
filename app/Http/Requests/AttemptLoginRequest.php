<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AttemptLoginRequest extends FormRequest
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
            'mobile' => ['required', 'regex:/(0)([ ]|-|[()]){0,2}9[0-9]([ ]|-|[()]){0,2}(?:[0-9]([ ]|-|[()]){0,2}){8}/', 'digits:11'],
            'password' => ['required'],
        ];
    }

    public function prepareForValidation()
    {
        $this->merge([
            'mobile' => toEnglishNumbers($this->input('mobile') ?? '')
        ]);
    }
    public function attributes()
    {
        return __('columns.login');
    }
}
