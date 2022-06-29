<?php

namespace App\Models;

use App\Traits\UuidTrait;
use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Translatable\HasTranslations;

class Course extends Model
{
    use HasFactory, Searchable, UuidTrait, HasTranslations, HasFactory;

    public $fillable = ['name',  'code', 'extra'];
    public $translatable = ['name'];
    protected $hidden = ['pivot'];

    public $casts = [
        'code' => 'array',
    ];

    public function toSearchableArray(): array
    {
        return [
            'id' => $this->uuid,
            'name' => $this->getTranslations('name'),
            'code' => $this->code,
            'programs' => $this->programs()->get()->map(function (Program $item, $key) {
                return [
                    'id' => $item->uuid,
                    'name' => $item->getTranslations('name'),
                ];
            })->toArray(),
        ];
    }

    /**
     * Get the value used to index the model.
     *
     * @return mixed
     */
    public function getScoutKey(): string
    {
        return $this->uuid;
    }

    /**
     * Get the key name used to index the model.
     *
     * @return mixed
     */
    public function getScoutKeyName(): string
    {
        return 'uuid';
    }

    public function offers()
    {
        return $this->belongsToMany(Offer::class, 'offers_courses', 'course_id', 'offer_id');
    }

    public function programs()
    {
        return $this->belongsToMany(Program::class, 'courses_programs', 'course_id', 'program_id');
    }
}
