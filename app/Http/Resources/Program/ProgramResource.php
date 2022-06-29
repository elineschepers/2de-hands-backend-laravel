<?php

namespace App\Http\Resources\Program;

use App\Models\Program;
use Illuminate\Http\Resources\Json\JsonResource;

class ProgramResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        /* @var $this Program */
        return [
            'uuid' => $this->uuid,
            'name' => $this->getTranslations('name'),
        ];
    }
}
