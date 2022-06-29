<?php

namespace App\Filters;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

abstract class FiltersAbstract
{
    protected Request $request;

    protected array $filters = [];

    /*
     * The filters that should always be executed
     * even when there is no value in the string
     * */
    protected array $default_filters = [];

    /**
     * FiltersAbstract constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @param Builder $builder
     * @return Builder
     */
    public function filter(Builder $builder): Builder
    {
        foreach ($this->filterFilters() as $filter => $value) {
            $this->resolveFilter($filter)->filter($builder, $value);
        }

        return $builder;
    }

    /**
     * @param array $filters
     * @return $this
     */
    public function add(array $filters): self
    {
        $this->filters = array_merge($this->filters, $filters);

        return $this;
    }

    /**
     * Creates a new filter instance
     *
     * @param $filter
     * @return FilterAbstract
     */
    protected function resolveFilter($filter): FilterAbstract
    {
        if (array_key_exists($filter, $this->default_filters)) {
            return new $this->default_filters[$filter]();
        }

        return new $this->filters[$filter]();
    }

    /**
     * @return array
     */
    protected function filterFilters(): array
    {
        $default_filters_request = $this->request->only(array_keys($this->default_filters));
        $default_filters = [];

        // Loop through all the default filters
        foreach ($this->default_filters as $default_filter_key => $default_filter) {
            // Check if the default filter exists in the request
            $value = $default_filters_request[$default_filter_key] ?? null;

            $default_filters[$default_filter_key] = $value;
        }

        // Only apply filters that are present in the request and default filters
        $filters = array_filter($this->request->only(array_keys($this->filters)));

        return array_merge($filters, $default_filters);
    }

    public static function mappings(): array
    {
        return [];
    }
}
