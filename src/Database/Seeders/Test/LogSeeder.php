<?php

namespace Logger\Database\Seeders\Test;

use Logger\Models\Log;

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
