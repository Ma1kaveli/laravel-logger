<?php

namespace Logger\Repositories;

use Core\Repositories\BaseRepository;
use Logger\Models\ActionLog;

class ActionLogRepository extends BaseRepository {
    protected string $successPrefix;

    protected string $errorPrefix;

    public function __construct() {
        parent::__construct(ActionLog::class);
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
        return $this->query()->where('slug', "$this->successPrefix.$slug")->first();
    }

    /**
     * get unsuccess action log by slug
     *
     * @param string $slug
     * @return ActionLog
     */
    public function getErrorActionLogBySlug(string $slug): ActionLog
    {
        return $this->query()->where('slug', "$this->errorPrefix.$slug")->first();
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
            $callback = config('actionlog.repository.description_callback');

            if (is_callable($callback)) {
                return $callback($this->user, $actionLog);
            }

            return $this->user->id . ') ' . $this->user->phone . ' - ' . $actionLog->name;
        }

        return $actionLog->name;
    }
}
