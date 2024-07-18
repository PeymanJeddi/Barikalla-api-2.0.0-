<?php

namespace App\Http\Resources\Steamer;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TargetPublicResource extends JsonResource
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
        ];
    }
}
