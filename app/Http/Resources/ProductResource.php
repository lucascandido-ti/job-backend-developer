<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            "id"            => $this->id,
            "name"          => $this->name,
            "price"         => $this->formatPrice($this->price),
            "description"   => $this->description,
            "category"      => $this->category,
            "image"         => $this->image_url,
        ];
    }

    private function formatPrice($val){
        return round(floatval($val), 2);
    }
}
