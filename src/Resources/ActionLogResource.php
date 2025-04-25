<?php

namespace LaravelLogger\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use LaravelQueryBuilder\Resources\PaginatedCollection;

class ActionLogResource extends JsonResource {
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'description' => $this->description,
            'logs' => new PaginatedCollection(
                $this->logs,
                LogResource::collection($this->logs)
            ),
        ];
    }
}
