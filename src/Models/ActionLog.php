<?php

namespace LaravelLogger\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ActionLog extends Model
{
    use HasFactory;

    protected $table = 'logs.action_logs';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'slug',
        'name',
        'description',
    ];

    /**
     * logs
     *
     * @return HasMany
     */
    public function logs(): HasMany
    {
        return $this->hasMany(Log::class, 'action_log_id', 'id');
    }
}
