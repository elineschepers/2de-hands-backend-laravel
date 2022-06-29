<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class ImageListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request): array
    {
        /** @var Media $this */
        $data = [
            'src' => $this->getFullUrl('resp'),
        ];

        // If we have responsive images
        if ($this->hasResponsiveImages('resp')) {
            $data = array_merge($data, [
                'srcset' => $this->getSrcset('resp'),
            ]);
        }

        return $data;
    }
}
