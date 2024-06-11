<?php

namespace App\Http\Resources\Donate;

use App\Http\Resources\Common\UserPublicInformationResource;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DonateResource extends JsonResource
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
            'user' => new UserPublicInformationResource($this->user),
            'streamer' => new UserPublicInformationResource($this->streamer),
            'amount' => $this->amount,
            'raw_amount' => $this->amount,
            'donator_information' => [
                'fullname' => $this->fullname,
                'mobile' => $this->mobile,
            ],
            'description' => $this->description,
            'created_at' => Carbon::parse($this->getRawOriginal('created_at'))
            ->getTimestamp(),
            'updated_at' => Carbon::parse($this->getRawOriginal('updated_at'))
            ->getTimestamp(),
        ];
    }
}
