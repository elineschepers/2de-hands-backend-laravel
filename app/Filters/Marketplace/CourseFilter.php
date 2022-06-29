<?php


namespace App\Filters\Marketplace;


use Ramsey\Uuid\Uuid;
use App\Filters\FilterAbstract;
use Illuminate\Database\Eloquent\Builder;

class CourseFilter extends FilterAbstract
{

    public function filter(Builder $builder, $value): Builder
    {
        // If value is a string, explode it into an array
        if (is_string($value)) {
            $value = explode(',', $value);
        }

        // If the value is not an array, return the builder
        if (!is_array($value)) {
            return $builder;
        }

        if (empty($value)) {
            return $builder;
        }

        // Only keep valid uuids
        $uuids = array_filter($value, static function ($val) {
            return Uuid::isValid($val);
        });

        return $builder->whereHas('courses', static function ($query) use ($uuids) {
            return $query->whereIn('uuid', $uuids);
        });
    }
}
