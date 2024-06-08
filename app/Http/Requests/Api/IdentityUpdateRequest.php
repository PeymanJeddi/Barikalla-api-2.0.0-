<?php

namespace App\Http\Requests\Api;

use App\Enums\UserGenderEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class IdentityUpdateRequest extends FormRequest
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
            'first_name' => ['nullable', 'max:255'],
            'last_name' => ['nullable', 'max:255'],
            'gender' => ['nullable', Rule::enum(UserGenderEnum::class)],
            'birthday' => ['nullable', 'date'],
            'national_id' => ['nullable'],
            'address' => ['nullable', 'max:255'],
            'postalcode' => ['nullable', 'max:10'],
            'fix_phone_number' => ['nullable'],
        ];
    }
}
