<?php

namespace LaravelLogger\Repositories;

use LaravelLogger\DTO\ActionLogShowDTO;
use LaravelLogger\Filters\LogFilters;
use LaravelLogger\Models\Log;

use Illuminate\Pagination\LengthAwarePaginator;
use LaravelQueryBuilder\Repositories\BaseRepository;

class LogRepository extends BaseRepository {

    public function __construct() {
        parent::__construct(new Log());
    }

    /**
     * Get full log list
     *
     * @param ActionLogShowDTO $dto
     * @param string $type
     *
     * @return LengthAwarePaginator
     */
    public function getCustomPaginatedList(ActionLogShowDTO $dto, string $type): LengthAwarePaginator
    {
        $logFilters = (new LogFilters($this->model->newQuery(), $dto->params));

        $logs = ($type === 'users')
            ? $logFilters->listByUser()
            : $logFilters->listByOrganization();

        return $logs;
    }
}
