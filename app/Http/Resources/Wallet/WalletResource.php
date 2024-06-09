<?php

namespace App\Http\Resources\Wallet;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WalletResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'credit' => $this->credit,
            'shaba' => $this->shaba,
            'bank_account_number' => $this->bank_account_number,
            'bank_card_number' => $this->bank_card_number,
            'is_automatic_checkout' => $this->is_automatic_checkout,
            'automatic_checkout_cycle' => $this->automatic_checkout_cycle,
            'automatic_checkout_min_amount' => $this->automatic_checkout_min_amount,
            'automatic_checkout_max_amount' => $this->automatic_checkout_max_amount,
            'updated_at' => Carbon::parse($this->getRawOriginal('updated_at'))
            ->getTimestamp(),
        ];
    }
}
