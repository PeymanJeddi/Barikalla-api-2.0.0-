<?php

namespace App\Http\Resources\Wallet;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WalletAuditResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'event' => $this->event,
            'old_values' => $this->old_values,
            'new_values' => $this->new_values,
            'url' => $this->url,
            'ip_address' => $this->ip_address,
            'user_agent' => $this->user_agent,
            'created_at' => Carbon::parse($this->getRawOriginal('created_at'))
            ->getTimestamp(),
            'updated_at' => Carbon::parse($this->getRawOriginal('updated_at'))
            ->getTimestamp(),
        ];
    }
}
