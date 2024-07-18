<?php

namespace App\Http\Resources\Steamer;

use App\Http\Resources\Attachment\AttachmentResource;
use App\Http\Resources\Common\KindResource;
use App\Http\Resources\User\Link\LinkResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StreamerResource extends JsonResource
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
            'avatar' => new AttachmentResource($this->avatar),
            'gateway' => [
                'biography' => $this->gateway->biography,
                'is_payment_active' => $this->gateway->is_payment_active,
                'job' => new KindResource($this->gateway->job),
                'min_donate' => $this->gateway->min_donate,
                'max_donate' => $this->gateway->max_donate,
                'is_donator_pay_wage' => $this->gateway->is_donator_pay_wage,
                'is_donator_pay_tax' => $this->gateway->is_donator_pay_tax,
            ],
            'targets' => TargetPublicResource::collection($this->targets),
            'links' => LinkResource::collection($this->links),
        ];
    }
}
