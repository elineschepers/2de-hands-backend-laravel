<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Ramsey\Uuid\Uuid;

trait UuidTrait
{
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            /**
             * Create a UUID
             */
            $uuid = Uuid::uuid1();

            /**
             * Set UUID to bytes optimized
             */
            $model->uuid = $uuid->toString();
        });
    }

    /**
     * @param $query
     * @param $uuid
     * @return mixed
     */
    public function scopeWithUUID($query, $uuid)
    {
        return $query->where('uuid', $uuid);
    }

    /**
     * @param $query
     * @param array $uuids
     * @return mixed
     */
    public function scopeWhereUUIDs($query, $uuids = [])
    {
        return $query->whereIn('uuid', $uuids);
    }

    /**
     * @param $query
     * @param array $uuids
     * @return mixed
     */
    public function scopeWhereNotUUIDs($query, $uuids = [])
    {
        return $query->whereNotIn('uuid', $uuids);
    }

    /**
     * Get the first item with the given UUID or fail
     *
     * @param $query
     * @param $uuid
     * @return mixed
     */
    public function scopeFirstUUID($query, $uuid)
    {
        if (is_null($uuid) || !Uuid::isValid($uuid))
            throw new ModelNotFoundException();

        return $query->withUUID($uuid)->firstOrFail();
    }
}
