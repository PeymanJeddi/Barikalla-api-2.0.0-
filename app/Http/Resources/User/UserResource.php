<?php

namespace App\Http\Resources\User;

use App\Http\Resources\Attachment\AttachmentResource;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'username' => $this->username,
            'referral_username' => $this->referral_username,
            'phone_number' => $this->mobile,
            'birthday' => Carbon::parse($this->getRawOriginal('birthday'))
            ->getTimestamp(),
            'description' => $this->description,
            'wallet_credit' => $this->wallet->credit,
            'avatar' => new AttachmentResource($this->avatar),
        ];
    }
}
