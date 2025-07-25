<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Prefix for success logs
    |--------------------------------------------------------------------------
    */
    'success_prefix' => 'success',

    /*
    |--------------------------------------------------------------------------
    | Prefix for unsuccess logs
    |--------------------------------------------------------------------------
    */
    'error_prefix' => 'error',

    /*
    |--------------------------------------------------------------------------
    | User model path
    |--------------------------------------------------------------------------
    */
    'user_model' => App\Models\User::class,

    /*
    |--------------------------------------------------------------------------
    | User resource model for LogResource
    |--------------------------------------------------------------------------
    */
    'user_resource' => [\App\Modules\Base\Resources\UserShortResource::class, 'once'],

    /*
    |--------------------------------------------------------------------------
    | Action Log slugs for seeder
    |--------------------------------------------------------------------------
    */
    'slug_list' => [],

    /*
    |--------------------------------------------------------------------------
    | Count create Logs in log factory
    |--------------------------------------------------------------------------
    */
    'logs_factory_count' => env('LOG_FACTORY', 1000),
];
