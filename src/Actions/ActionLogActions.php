<?php

namespace LaravelLogger\Actions;

use LaravelLogger\DTO\ActionLogShowDTO;
use LaravelLogger\Filters\LogFilters;
use LaravelLogger\Models\ActionLog;
use LaravelLogger\Models\Log;
use LaravelLogger\Repositories\ActionLogRepository;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class ActionLogActions {
    public ActionLogRepository $actionLogRepository;

    public function __construct()
    {
        $this->actionLogRepository = new ActionLogRepository();
    }

    /**
     * showById
     *
     * @param ActionLogShowDTO $params
     * 
     * @return ActionLog|Collection|Model
     */
    public function showById(ActionLogShowDTO $dto): ActionLog|Collection|Model
    {
        $actionLog = $this->actionLogRepository->findByIdOrFail($dto->params['action_log_id']);

        $actionLog['logs'] = (new LogFilters(Log::query(), $dto->params))->fullList();

        return $actionLog;
    }
}
