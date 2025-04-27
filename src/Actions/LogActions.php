<?php

namespace Logger\Actions;

use Logger\Repositories\LogRepository;

class LogActions {
    public LogRepository $logRepository;

    public function __construct()
    {
        $this->logRepository = new LogRepository();
    }
}
