<?php

namespace LaravelLogger\Filters;

use LaravelQueryBuilder\BaseQueryBuilder;

use Illuminate\Pagination\LengthAwarePaginator;
use LaravelQueryBuilder\DTO\AvailableSort;
use LaravelQueryBuilder\DTO\AvailableSorts;

class LogFilters extends BaseQueryBuilder
{
    /**
     * list
     *
     * @return LengthAwarePaginator
     */
    public function list(): LengthAwarePaginator
    {
        $this->with('user');
        $this->applyWhereHasLikeArray(
            'user', [
                'name', 'patronymic', 'family_name',
                'phone', 'email'
            ], 'search'
        );
        $this->applyDateStartEnd('created_at', 'date_from', 'date_to');
        $this->sortBy(['created_at'], null);
        $this->applyInteger('action_log_id');
        $this->sortByRelationField(
            new AvailableSorts([
                new AvailableSort(
                    'users.phone',
                    'users',
                    'id',
                    'created_by',
                ),
                new AvailableSort(
                    'users.family_name',
                    'users',
                    'id',
                    'created_by',
                ),
                new AvailableSort(
                    'logs.action_logs.id',
                    'logs.action_logs',
                    'id',
                    'action_log_id',
                ),
            ]),
            'logs.logs'
        );

        return $this->applyPaginate();
    }

    /**
     * list by user
     *
     * @return LengthAwarePaginator
     */
    public function listByUser(): LengthAwarePaginator
    {
        $this->applyInteger('created_by');

        return $this->list();
    }

    /**
     * list by organization id
     *
     * @return LengthAwarePaginator
     */
    public function listByOrganization()
    {
        $this->applyWhereHasWhere('user.role', 'organization_id');

        return $this->list();
    }

    /**
     * full list
     *
     * @return LengthAwarePaginator
     */
    public function fullList(): LengthAwarePaginator
    {
        $this->applyInteger('created_by');
        $this->applyWhereHasWhere('user.role', 'organization_id');

        return $this->list();
    }
}
