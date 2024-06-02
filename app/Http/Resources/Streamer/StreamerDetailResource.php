<?php

namespace App\Http\Resources\Streamer;

use App\Http\Resources\Common\KindResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StreamerDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'nickname' => $this->nickname,
            'is_payment_active' => $this->is_payment_active,
            'job' => new KindResource($this->job),
            'min_donate' => $this->min_donate,
            'max_donate' => $this->max_donate,
            'is_donator_pay_wage' => $this->is_donator_pay_wage,
            'is_donator_pay_tax' => $this->is_donator_pay_tax,
        ];
    }
}
