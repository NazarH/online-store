<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'type' => $this->type,
            'location' => $this->location,
            'number' => $this->number,
            'email' => $this->email,
            'phone' => $this->phone,
            'name' => $this->name,
            'payment' => $this->payment,
            'status' => $this->status
        ];
    }
}
