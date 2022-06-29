<?php

namespace App\Http\Resources\Course;

use App\Http\Resources\Program\ProgramResource;
use App\Models\Course;
use Illuminate\Http\Resources\Json\JsonResource;

class CourseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        /** @var $this Course */
        $this->load('programs');

        return [
            'uuid' => $this->uuid,
            'name' => $this->getTranslations('name'),
            'code' => $this->code,
            'programs' => ProgramResource::collection($this->programs)
        ];
    }
}
