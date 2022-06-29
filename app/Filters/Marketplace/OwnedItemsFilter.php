<?php

namespace App\Filters\Marketplace;

use App\Filters\FilterAbstract;
use Illuminate\Database\Eloquent\Builder;

class OwnedItemsFilter extends FilterAbstract
{
    public function filter(Builder $builder, $value): Builder
    {
        $value = filter_var($value, FILTER_VALIDATE_BOOLEAN);

        if ($value && auth()->check()) {
            return $builder->where('user_id', auth()->id());
        }

        return $builder;
    }
}
