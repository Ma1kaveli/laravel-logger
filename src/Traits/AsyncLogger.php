<?php

namespace Logger\Traits;

use Logger\Jobs\JProcessLogSave;

use Illuminate\Support\Facades\Auth;

trait AsyncLogger
{
    /**
     * successAsyncLog
     *
     * @param string $slug
     *
     * @return void
     */
    public function successAsyncLog(string $slug): void
    {
        JProcessLogSave::dispatchSuccess($slug, Auth::user());
    }

    /**
     * errorAsyncLog
     *
     * @param string $slug
     * @param ?string $error
     *
     * @return void
     */
    public function errorAsyncLog(string $slug, ?string $error = null): void
    {
        JProcessLogSave::dispatchError($slug, Auth::user(), $error);
    }

    /**
     * softMethodAsyncLogger
     *
     * @param string $slug
     * @param array $data
     *
     * @return void
     */
    public function softMethodAsyncLogger(string $slug, array $data): void
    {
        JProcessLogSave::dispatchSoftMethod($slug, Auth::user(), $data);
    }
}