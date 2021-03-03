<?php

declare(strict_types=1);

namespace ExempleFiltersQueryBuild\Filters;

use App\Domain\Filters\BaseFilters as Base;
use Carbon\Carbon;

abstract class ExempleBaseFilters extends Base
{
    /** @param string|string[] $date */
    public function date($date): void
    {
        if (is_array($date)) {
            $start = $date['start'] ?? '';
            $end   = $date['end'] ?? '';

            // Use between only if start and end dates are differents
            if ($start !== $end) {
                $this->builder->whereBetween(
                    'cover_sheets.start_date',
                    [
                        $start,
                        $end,
                    ]
                );

                return;
            }

            $date = $start;
        }

        $this->builder->where('cover_sheets.start_date', $date);
    }

    /** @param string $date*/
    public function findDate(string $date): void
    {
        $this->filterBetweenDate(
            'cover_sheets.created_at',
            $date
        );
    }

    /** @param int[] $id */
    public function ids(array $ids): void
    {
        $this->builder->whereIn('cover_sheets.id', $ids);
    }

    /** @param int[] $registrations */
    public function registrations(array $registrations): void
    {
        $this->builder->whereIn('tim_corp_core.users.registration', $registrations);
    }

    /** @param string $status*/
    public function status(array $status): void
    {
        $this->builder->whereIn('cover_sheets.status', $status);
    }

    /** @param  string[] $costCenter */
    public function costCenter(array $costCenter): void
    {
        $this->builder->whereIn('cover_sheets.cost_center', $costCenter);
    }


    /** @param  string[] $licencePlate */
    public function licencePlate(array $licencePlate): void
    {
        $this->builder->whereIn('cover_sheets.licence_plate', $licencePlate);
    }


    /** @param  int[] $views */
    public function views(array $views): void
    {
        $this->builder->whereIn('views.id', $views);
    }

    /** @param  int[] $subViews */
    public function subViews(array $subViews): void
    {
        $this->builder->whereIn('sub_view.id', $subViews);
    }

    protected function filterBetweenDate(string $field, string $date): void
    {
        $date = new Carbon($date);

        $this->builder->whereBetween(
            $field,
            [
                (string) $date->startOfDay(),
                (string) $date->endOfDay()
            ]
        );
    }
}
