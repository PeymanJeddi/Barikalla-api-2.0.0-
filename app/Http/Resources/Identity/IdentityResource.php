<?php

namespace App\Http\Resources\Identity;

use App\Http\Resources\Attachment\AttachmentResource;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class IdentityResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'gender' => $this->gender,
            'birthday' => $this->when($this->birthday == null, null, Carbon::parse($this->birthday)
            ->getTimestamp() ),
            'national_id' => $this->national_id,
            'address' => $this->address,
            'email' => $this->email,
            'mobile' => $this->mobile,
            'postalcode' => $this->postalcode,
            'fix_phone_number' => $this->fix_phone_number,
            'documents' => [
                'birth_certificate' => new AttachmentResource($this->birthCertificate),
                'national_card' => new AttachmentResource($this->nationalCard),
            ],
            'status' => $this->status,
        ];
    }
}
