<?php

declare(strict_types=1);

namespace ExempleFiltersQueryBuild\Filters;

use Illuminate\Database\Eloquent\Builder;

/**
 * Class to process builder for filters.
 */
abstract class AbstractExempleBaseFilters
{
    /** @var Builder */
    protected $builder;

    /** @var bool */
    protected $nullableValues = true;

    /** @var string[] */
    private $availablesFilters = [];

    public function __construct(Builder $builder)
    {
        $this->builder           = $builder;
        $this->availablesFilters = $this->getAvailablesFilters();
    }

    public function build(array $filters = []): Builder
    {
        foreach ($filters as $filter => $value) {
            if ($this->checkFilterAndValue($filter, $value)) {
                $function = $this->filterToCamelCase($filter);

                $this->$function($value);
            }
        }

        return $this->builder;
    }

    /** @param string[] */
    public function getAvailablesFilters(): array
    {
        return [];
    }

    /** @param mixed $value */
    protected function checkFilterAndValue(string $filter, $value): bool
    {
        if (is_null($value) && !$this->nullableValues) {
            return false;
        }

        return $this->hasFilter($filter, $value)
            && $this->filterIsCallable($filter);
    }

    /** @param mixed $value */
    protected function hasFilter(string $filter, $value): bool
    {
        return in_array($filter, $this->availablesFilters);
    }

    protected function filterIsCallable(string $filter): bool
    {
        $filter = $this->filterToCamelCase($filter);

        return method_exists($this, $filter);
    }

    protected function filterToCamelCase(string $filter): string
    {
        return lcfirst($this->camelize($filter));
    }

    protected function camelize(string $input, string $separator = '_'): string
    {
        return str_replace($separator, '', ucwords($input, $separator));
    }
}
