<?php

namespace LaravelLogger\Facades;

use Illuminate\Support\Facades\Log;

class LaravelLog extends Log
{
  /**
   * error
   *
   * @param  string $message
   * @param  array $context
   * @return void
   */
  public static function error($message, $context = []) {
    static::getFacadeApplication()->make('sentry')->captureException($message);
    parent::error($message, $context);
  }
}
