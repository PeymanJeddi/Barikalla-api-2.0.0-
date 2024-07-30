<?php

namespace App\Http\Resources\Overlay;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TargetResource extends JsonResource
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
            'title' => $this->title,
            'target' => $this->target,
            'target_donated' => $this->target_donated + $this->default_donated_amount,
        ];
    }
}
