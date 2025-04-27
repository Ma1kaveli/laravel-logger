<?php

namespace Logger\Database\Factories;

use Logger\Models\ActionLog;
use Logger\Models\Log;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\LaravelLogger\Models\Log>
 */
class LogFactory extends Factory
{
    protected $model = Log::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'action_log_id' => ActionLog::inRandomOrder()->first()->id,
            'is_error' => rand(0, 1),
            'description' => fake()->text(),
            'error_description' => fake()->text(),
        ];
    }
}
