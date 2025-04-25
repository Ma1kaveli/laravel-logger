<?php

namespace LaravelLogger\Actions;

use LaravelLogger\Repositories\LogRepository;

class LogActions {
    public LogRepository $logRepository;

    public function __construct()
    {
        $this->logRepository = new LogRepository();
    }
}
