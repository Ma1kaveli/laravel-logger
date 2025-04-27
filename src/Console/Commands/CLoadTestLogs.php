<?php

namespace Logger\Console\Commands;

use Logger\Database\Seeders\Test\LogSeeder;

use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class CLoadTestLogs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'seed:test-logs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command for start seed who add test logs';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        try {
            DB::beginTransaction();
            $this->info('Loading test logs...');
            $this->call(LogSeeder::class);
            $this->info('Success!');
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            return $e;
        }
        return 1;
    }
}
