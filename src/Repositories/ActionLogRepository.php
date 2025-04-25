<?php

namespace LaravelLogger\Repositories;

use LaravelLogger\Models\ActionLog;

use LaravelQueryBuilder\Repositories\BaseRepository;

class ActionLogRepository extends BaseRepository {
    protected string $successPrefix;

    protected string $errorPrefix;

    public function __construct() {
        parent::__construct(new ActionLog());
        $this->successPrefix = config('logger.success_prefix');
        $this->errorPrefix = config('logger.error_prefix');
    }

    /**
     * get success action log by slug
     *
     * @param string $slug
     * @return ActionLog
     */
    public function getSuccessActionLogBySlug(string $slug): ActionLog
    {
        return $this->model->where('slug', "$this->successPrefix.$slug")->first();
    }

    /**
     * get unsuccess action log by slug
     *
     * @param string $slug
     * @return ActionLog
     */
    public function getErrorActionLogBySlug(string $slug): ActionLog
    {
        return $this->model->where('slug', "$this->errorPrefix.$slug")->first();
    }

    /**
     * get description
     *
     * @param ActionLog $actionLog
     *
     * @return string
     */
    public function getDescription(ActionLog $actionLog): string {
        if ($this->isAuth()) {
            // TODO: put it in the config
            return $this->user->id . ') ' . $this->user->phone . ' - ' .  $actionLog->name;
        }


        return $actionLog->name;
    }
}
