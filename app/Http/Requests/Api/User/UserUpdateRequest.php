<?php

namespace App\Http\Requests\Api\User;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
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
        $userId = auth()->id();
        return [
            'nickname' => ['required', 'max:255'],
            'first_name' => ['nullable', 'max:255'],
            'last_name' => ['nullable', 'max:255'],
            'username' => ['required', 'max:255', "unique:users,username,$userId"],
            'referral_username' => ['nullable', 'exists:users,username'],
            'description' => ['nullable', 'max:3000'],
            'birthday' => ['nullable'],
        ];
    }
}
