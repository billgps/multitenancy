<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ConditionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'event_date' => $this->event_date,
            'event' => $this->event,
            'status' => $this->status,
        ];
    }
}
