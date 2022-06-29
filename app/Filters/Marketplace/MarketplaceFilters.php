<?php

namespace App\Filters\Marketplace;

use App\Filters\FiltersAbstract;

class MarketplaceFilters extends FiltersAbstract
{
    protected array $filters = [
        'owned' => OwnedItemsFilter::class,
        'courses' => CourseFilter::class,
    ];
}
