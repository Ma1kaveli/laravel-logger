<?php

namespace Logger\Actions;

use Logger\Facades\LaravelLog;
use Logger\DTO\LogCreateDTO;
use Logger\Repositories\ActionLogRepository;
use Logger\Services\LogService;

use Exception;

class LoggerActions {
    public LogService $service;

    public ActionLogRepository $actionLogRepository;

    protected int|null $createdBy;

    public string $slug;

    public function __construct(string $slug) {
        $this->slug = $slug;

        $this->service = new LogService();
        $this->actionLogRepository = new ActionLogRepository();

        $this->createdBy = $this->actionLogRepository->getAuthUserId();
    }

    /**
     * Add log for success action
     *
     * @return void
     */
    public function successLog(): void
    {
        $actionLog = $this->actionLogRepository->getSuccessActionLogBySlug($this->slug);
        $description = $this->actionLogRepository->getDescription($actionLog);

        try {
            $this->service->create(
                LogCreateDTO::fromDatas($actionLog, $description, $this->createdBy)
            );
        } catch (Exception $e) {
            LaravelLog::error($e);
        }
    }

    /**
     * Add log for unsuccess action
     *
     * @param string|null $error
     *
     * @return void
     */
    public function errorLog(?string $error = null): void
    {
        $actionLog = $this->actionLogRepository->getErrorActionLogBySlug($this->slug);
        $description = $this->actionLogRepository->getDescription($actionLog);

        try {
            $this->service->create(
                LogCreateDTO::fromDatas($actionLog, $description, $this->createdBy, true, $error)
            );
            LaravelLog::error($error);
        } catch (Exception $e) {
            LaravelLog::error($e);
        }
    }

    /**
     * Method for delete/restore methods
     *
     * @param array $data
     *
     * @return void
     */
    public function softMethodLogger(array $data): void
    {
        if ($data['code'] === 200) $this->successLog();
        $this->errorLog($data['message']);
    }
}
