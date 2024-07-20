<?php

namespace App\Http\Requests\Admin\User;

use App\Enums\UserStatusEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
        $user = $this->user;
        return [
            'first_name' => ['nullable', 'max:255'],
            'last_name' => ['nullable', 'max:255'],
            'is_admin' => ['nullable', 'boolean'],
            'username' => ['nullable', "unique:users,username,$user->id"],
            'nickname' => ['nullable', 'max:255'],
            'referral_username' => ['nullable', 'exists:users,username'],
            'birthday' => ['nullable', 'date'],
            'postalcode' => ['nullable', 'integer'],
            'mobile' => ['required', 'regex:/(0)([ ]|-|[()]){0,2}9[0-9]([ ]|-|[()]){0,2}(?:[0-9]([ ]|-|[()]){0,2}){8}/', 'digits:11', "unique:users,mobile,$user->id"],
            'fix_phone_number' => ['nullable', 'digits:8'],
            'email' => ['nullable', 'email'],
            'is_active' => ['nullable', 'boolean'],
            'status' => ['required', Rule::enum(UserStatusEnum::class)],
        ];
    }

    public function attributes()
    {
        return __('models.user');
    }
}
