<?php

namespace Logger\Jobs;

use Logger\Facades\LaravelLog;
use Logger\Traits\Logger;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;

use function Laravel\Prompts\error;

class JProcessLogSave implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, Logger;

    /**
     * @var string
     */
    protected string $slug;

    /**
     * @var ?string
     */
    protected ?string $error;

    /**
     * @var Authenticatable
     */
    protected Authenticatable $user;

    /**
     * @var array
     */
    protected array $data;

    /**
     * success | error | soft_method
     *
     * @var string
     */
    protected string $logType;

    /**
     * Количество секунд, в течение которых задание может выполняться до истечения тайм-аута.
     *
     * @var int
     */
    public $timeout = 36000;

    /**
     * Create a new job instance.
     *
     * @param string $slug
     * @param Authenticatable $user
     * @param ?string $error = null
     * @param string $logType = 'success'
     * @param array $data = []
     *
     * @return void
     */
    public function __construct(
        string $slug,
        Authenticatable $user,
        ?string $error = null,
        string $logType = 'success',
        array $data = []
    ) {
        $this->slug = $slug;

        $this->user = $user;

        $this->error = $error;

        $this->logType = $logType;

        $this->data = $data;
    }

    public function failed(\Throwable $exception)
    {
        LaravelLog::critical('JProcessLogSave: Job FAILED with error: ' . $exception->getMessage());
        // Send notification to admin, etc.
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Auth::setUser($this->user);
        LaravelLog::info('JProcessLogSave: Starting job...');
        try {
            switch ($this->logType) {
                case 'error':
                    $this->errorLog($this->slug, $this->error);
                    break;

                case 'soft_method':
                    $this->softMethodLogger($this->slug, $this->data ?? []);
                    break;

                case 'success':
                default:
                    $this->successLog($this->slug);
                    break;
            }

            LaravelLog::info('JProcessLogSave: Job completed successfully.');
        } catch (\Exception $e) {
            LaravelLog::error('JProcessLogSave: Job failed with error: ' . $e->getMessage());
            throw $e; // Важно пробросить исключение, чтобы задача была помечена как неудачная.
        }
    }

    /**
     * dispatchSuccess
     *
     * @param string $slug
     * @param Authenticatable $user
     *
     * @return void
     */
    public static function dispatchSuccess(string $slug, Authenticatable $user): void
    {
        self::dispatch($slug, $user, null, null, 'success');
    }

    /**
     * dispatchError
     *
     * @param string $slug
     * @param Authenticatable $user
     * @param ?string $error
     *
     * @return void
     */
    public static function dispatchError(string $slug, Authenticatable $user, ?string $error): void
    {
        self::dispatch($slug, $user, $error, null, 'error');
    }

    /**
     * dispatchSoftMethod
     *
     * @param string $slug
     * @param Authenticatable $user
     * @param array $data
     *
     * @return void
     */
    public static function dispatchSoftMethod(string $slug, Authenticatable $user, array $data): void
    {
        self::dispatch($slug, $user, null, $data, 'soft_method');
    }
}
