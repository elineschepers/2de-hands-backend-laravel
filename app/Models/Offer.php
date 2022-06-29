<?php

namespace App\Models;

use App\Traits\UuidTrait;
use Laravel\Scout\Searchable;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Filters\Marketplace\MarketplaceFilters;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Offer extends Model implements HasMedia
{
    use UuidTrait, SoftDeletes, InteractsWithMedia, Searchable, HasFactory;

    protected $fillable = ['title', 'description', 'price', 'is_sold', 'user_id'];

    protected $hidden = [];

    public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection('images_' . $this->id)
            ->useDisk(config('medialibrary.disk_name'));
    }

    /**
     * @throws \Spatie\Image\Exceptions\InvalidManipulation
     */
    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->crop(Manipulations::CROP_CENTER, 200, 200)
            ->quality(60);

        $this->addMediaConversion('resp')
            ->quality(75)
            ->withResponsiveImages();
    }

    public function getFirstThumbImage(): String
    {
        $media = $this->getFirstMedia('images_' . $this->id);

        if ($media && $media->hasGeneratedConversion('thumb')) {
            return $media->getFullUrl('thumb');
        }

        return '';
    }

    /**
     * @param Builder $builder
     * @param $request
     * @param array $filters
     * @return Builder
     */
    public function scopeFilter(Builder $builder, $request, array $filters = []): Builder
    {
        return (new MarketplaceFilters($request))->add($filters)->filter($builder);
    }

    /**
     * Get the indexable data array for the model.
     *
     * @return array
     */
    public function toSearchableArray(): array
    {
        $array = $this->toArray();

        // Remove sensitive data
        unset($array['uuid'], $array['id'], $array['updated_at'], $array['user_id']);

        $array['id'] = $this->uuid;
        $array['user'] = $this->user->fullName();

        return $array;
    }

    public function getScoutKey(): string
    {
        return $this->uuid;
    }

    public function getScoutKeyName(): string
    {
        return 'uuid';
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function courses()
    {
        return $this->belongsToMany(Course::class, 'offers_courses', 'offer_id', 'course_id');
    }
}
