<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
            'name' => $this->name,
            'price' => $this->price,
            'old_price' => $this->old_price,
            'article' => $this->article,
            'count' => $this->count,
            'slug' => $this->slug,
            'url' => collect($this->getMedia('images')->all())->map(function($item){
               return $item->getUrl('thumb');
            })
        ];
    }
}
