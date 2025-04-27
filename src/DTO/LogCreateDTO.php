<?php

namespace Logger\DTO;

use Logger\Models\ActionLog;

class LogCreateDTO {
    public function __construct(
        public readonly int $actionLogId,
        public readonly string $description,
        public readonly ?int $createdBy = null,
        public readonly bool $isError = false,
        public readonly ?string $errorDescription = null,
    ) {}

    /**
     * @param ActionLog $actionLog
     * @param string $description
     * @param int $createdBy
     * @param bool $isError
     * @param ?string $errorText
     *
     * @return LogCreateDTO
     */
    public static function fromDatas(
        ActionLog $actionLog,
        string $description,
        ?int $createdBy = null,
        bool $isError = false,
        ?string $errorText = null,
    ): LogCreateDTO {
        return new self(
            actionLogId: $actionLog->id,
            description: $description,
            createdBy: $createdBy,
            isError: $isError,
            errorDescription: $errorText,
        );
    }
}
