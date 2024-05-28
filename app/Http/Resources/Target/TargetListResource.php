<?php

namespace App\Http\Resources\Target;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TargetListResource extends JsonResource
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
            'description' => $this->description,
            'target' => $this->target,
            'target_donated' => $this->target_donated,
            'is_active' => $this->is_active,
            'created_at' => Carbon::parse($this->getRawOriginal('created_at'))
            ->getTimestamp(),
            'updated_at' => Carbon::parse($this->getRawOriginal('updated_at'))
            ->getTimestamp(),
        ];
    }
}
