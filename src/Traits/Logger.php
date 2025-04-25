<?php

namespace LaravelLogger\Traits;

use LaravelLogger\Actions\LoggerActions;

trait Logger {

    /**
     * Add log for success action
     *
     * @param string $slug
     *
     * @return void
     */
    public function successLog(string $slug): void
    {
        (new LoggerActions($slug))->successLog();
    }

    /**
     * Add log for unsuccess action
     *
     * @param string $slug
     * @param string|null $error
     *
     * @return void
     */
    public function errorLog(string $slug, ?string $error = null): void
    {
        (new LoggerActions($slug))->errorLog($error);
    }

    /**
     * Used for delete/restore method with crudler
     *
     * @param string $slug
     * @param array $data
     *
     * @return void
     */
    public function softMethodLogger(string $slug, array $data): void
    {
        (new LoggerActions($slug))->softMethodLogger($data);
    }
}
