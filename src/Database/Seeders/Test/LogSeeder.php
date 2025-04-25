<?php

namespace LaravelLogger\Database\Seeders\Test;

use LaravelLogger\Models\Log;

use Illuminate\Database\Seeder;

class LogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Log::factory(config('logger.logs_factory_count'))->create();
    }
}
