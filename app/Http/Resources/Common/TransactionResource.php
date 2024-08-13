<?php

namespace App\Http\Resources\Common;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
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
            'order_id' => $this->order_id,
            'user' => new UserPublicInformationResource($this->user),
            'amount' => $this->amount,
            'raw_amount' => $this->raw_amount,
            'type' => $this->type,
            'created_at' => Carbon::parse($this->getRawOriginal('created_at'))
            ->getTimestamp(),
        ];
    }
}
