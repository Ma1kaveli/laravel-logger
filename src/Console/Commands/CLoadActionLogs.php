<?php

namespace LaravelLogger\Console\Commands;

use LaravelLogger\Database\Seeders\ActionLogSeeder;

use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class CLoadActionLogs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'seed:action-logs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command for start seed who add action logs';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        try {
            DB::beginTransaction();
            $this->info('Loading action log list...');
            $this->call(ActionLogSeeder::class);
            $this->info('Success!');
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            return $e;
        }
        return 1;
    }
}
