<?php

namespace Logger\Services;

use Logger\DTO\LogCreateDTO;
use Logger\Models\Log;

class LogService {
    public function __construct() {}

    /**
     * create
     *
     * @param LogCreateDTO $dto
     * @return Log
     */
    public function create(LogCreateDTO $dto): Log {
        return Log::create([
            'action_log_id' => $dto->actionLogId,
            'error_description' => $dto->errorDescription,
            'is_error' => $dto->isError,
            'description' => $dto->description,
            'created_by' => $dto->createdBy,
        ]);
    }
}
