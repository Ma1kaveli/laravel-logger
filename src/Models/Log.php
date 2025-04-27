<?php

namespace Logger\Models;

use Logger\Database\Factories\LogFactory;
use Logger\Filters\LogFilters;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use QueryBuilder\Traits\Filterable;

class Log extends Model
{
    use HasFactory, Filterable;

    protected $table = 'logs.logs';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'action_log_id',
        'is_error',
        'description',
        'error_description',
        'created_by',
        'created_at',
        'updated_at'
    ];

    /**
     * newFactory
     *
     * @return mixed
     */
    protected static function newFactory()
    {
        return LogFactory::new();
    }

    /**
     * getFilterClass
     *
     * @return string
     */
    public static function getFilterClass(): string {
        return LogFilters::class;
    }


    /**
     * user
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(config('logger.user_model'), 'created_by', 'id');
    }

    /**
     * actionLog
     *
     * @return BelongsTo
     */
    public function actionLog(): BelongsTo
    {
        return $this->belongsTo(ActionLog::class, 'action_log_id', 'id');
    }
}
