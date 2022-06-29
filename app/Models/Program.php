<?php

namespace App\Models;

use App\Traits\UuidTrait;
use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Program extends Model
{
    use HasFactory, UuidTrait, Searchable, HasTranslations, HasFactory;

    public $fillable = ['name', 'extra'];
    public $translatable = ['name'];

    public function toSearchableArray(): array
    {
        return [
            'id' => $this->uuid,
            'name' => $this->getTranslations('name'),
        ];
    }

    public function getScoutKey()
    {
        return $this->uuid;
    }

    public function getScoutKeyName(): string
    {
        return 'uuid';
    }
    public function courses()
    {
        return $this->belongsToMany(Course::class, 'courses_programs', 'program_id', 'course_id');
    }
}
