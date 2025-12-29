<?php

namespace Logger\Repositories;

use Logger\DTO\ActionLogShowDTO;
use Logger\Filters\LogFilters;
use Logger\Models\Log;

use Core\Repositories\BaseRepository;
use Illuminate\Pagination\LengthAwarePaginator;

class LogRepository extends BaseRepository {

    public function __construct() {
        parent::__construct(Log::class);
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
        $logFilters = (new LogFilters($this->query(), $dto->params));

        $logs = ($type === 'users')
            ? $logFilters->listByUser()
            : $logFilters->listByOrganization();

        return $logs;
    }
}
