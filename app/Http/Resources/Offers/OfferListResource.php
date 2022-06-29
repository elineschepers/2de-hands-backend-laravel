<?php

namespace App\Http\Resources\Offers;

use App\Models\Offer;
use Illuminate\Http\Resources\Json\JsonResource;

class OfferListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        /** @var Offer $this */
        return [
            'uuid' => $this->uuid,
            'title' => $this->title,
            'price' => $this->price,
            'thumb' => $this->getFirstThumbImage()
        ];
    }
}
