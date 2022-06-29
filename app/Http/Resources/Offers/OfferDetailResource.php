<?php

namespace App\Http\Resources\Offers;

use App\Http\Resources\Course\CourseResource;
use App\Http\Resources\ImageListResource;
use Illuminate\Http\Resources\Json\JsonResource;

class OfferDetailResource extends JsonResource
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
            'uuid' => $this->uuid,
            'title' => $this->title,
            'description' => $this->description,
            'price' => $this->price,
            'user' => [
                'name' => optional($this->user)->first_name,
            ],
            'images' => ImageListResource::collection($this->media),
            'courses' => CourseResource::collection($this->courses),
        ];
    }
}
