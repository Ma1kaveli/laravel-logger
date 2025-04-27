<?php

namespace Logger\Facades;

use Illuminate\Support\Facades\Log;

class LaravelLog extends Log
{
    /**
     * error
     *
     * @param mixed $message
     * @param array $context
     *
     * @return void
     */
    public static function error($message, array $context = []): void {
        try {
            $sentry = app('sentry');

            if ($message instanceof \Throwable) {
                $sentry->captureException($message, $context);
            } else {
                $sentry->captureMessage($message, \Monolog\Logger::ERROR, $context);
            }
        } catch (\Throwable $e) {
            parent::error($e->getMessage(), $context);
        }

        parent::error($message, $context);
    }
}
