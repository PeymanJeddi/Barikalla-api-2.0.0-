<?php

namespace App\Http\Resources\User\Link;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LinkResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'link' => [
                'id' => $this->id,
                'type' => $this->value_1,
                'prefix' => $this->value_2,
            ],
            'value' => $this->pivot->value,
            'url' => $this->value_2 . $this->pivot->value,
        ];
    }
}
