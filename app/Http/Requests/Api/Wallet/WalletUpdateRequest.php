<?php

namespace App\Http\Requests\Api\Wallet;

use App\Enums\WalletAutomaticCheckoutCycleEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class WalletUpdateRequest extends FormRequest
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
            'shaba' => ['nullable', 'string', 'numeric'],
            'bank_account_number' => ['nullable', 'string', 'numeric'],
            'bank_card_number' => ['nullable', 'string', 'numeric', 'digits:16'],
            'is_automatic_checkout' => ['nullable', 'boolean'],
            'automatic_checkout_cycle' => ['nullable', Rule::enum(WalletAutomaticCheckoutCycleEnum::class)],
            'automatic_checkout_min_amount' => ['nullable', 'string', 'numeric'],
            'automatic_checkout_max_amount' => ['nullable', 'string', 'numeric'],
        ];
    }
}
