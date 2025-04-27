<?php

namespace Logger\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ActionLogShortResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'description' => $this->description,
        ];
    }
}
