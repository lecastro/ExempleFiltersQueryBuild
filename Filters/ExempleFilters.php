<?php

declare(strict_types=1);

namespace ExempleFiltersQueryBuild\Filters;

class ExempleFilters extends BaseFilters
{
    /** @var bool */
    protected $nullableValues = false;

    /** @return string[] */
    public function getAvailablesFilters(): array
    {
        return [
            'date',
            'find_date',
            'status',
            'users',
            'registrations',
            'cost_center',
            'licence_plate',
            'views',
            'sub_views',
            'ids'
        ];
    }

    /** @param  int[] $users */
    protected function users(array $users): void
    {
        $this->builder->whereIn('tim_corp_core.users.id', $users);
    }
}
