<?php

namespace App\Http\Requests\Api\Donation;

use Illuminate\Foundation\Http\FormRequest;

class DonationStoreController extends FormRequest
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
            'streamer_username' => ['required', 'exists:users,username'],
            'amount' => ['required', 'integer', 'min:1000'],
            'phone_number' => ['required', 'regex:/(0)([ ]|-|[()]){0,2}9[0-9]([ ]|-|[()]){0,2}(?:[0-9]([ ]|-|[()]){0,2}){8}/', 'digits:11'],
            'fullname' => ['required', 'max:255'],
            'description' => ['nullable', 'max:3000'],
            'sandbox' => ['nullable', 'boolean']
        ];
    }

    public function prepareForValidation()
    {
        $this->merge([
            'phone_number' => toEnglishNumbers($this->input('phone_number') ?? '')
        ]);

        $this->merge([
            'phone_number' => correctPhoneNumber($this->input('phone_number') ?? '')
        ]);
    }
}
