<?php

namespace Logger\Database\Seeders;

use Logger\Models\ActionLog;

use Illuminate\Database\Seeder;

class ActionLogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (config('logger.slug_list') as $el) {
            $existActionLog = ActionLog::where('slug', $el['slug'])->first();

            if (!empty($existActionLog)) continue;

            ActionLog::create([
                'name' => $el['name'],
                'slug' => $el['slug'],
            ]);
        }
    }
}
