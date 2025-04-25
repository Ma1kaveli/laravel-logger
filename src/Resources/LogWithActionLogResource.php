<?php

namespace LaravelLogger\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LogWithActionLogResource extends JsonResource {
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'created_by' => $this->created_by,
            'created_at' => $this->created_at,
            'action_log_id' => $this->action_log_id,
            'description' => $this->description,
            'error_description' => $this->error_description,
            'is_error' => $this->is_error,
            'action_log' => new ActionLogShortResource($this->actionLog),
            'user' =>
                config('logger.user_resource')
                ? config('logger.user_resource')($this->user)
                : $this->user,
        ];
    }
}
