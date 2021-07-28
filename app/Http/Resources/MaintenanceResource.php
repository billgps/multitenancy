<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MaintenanceResource extends JsonResource
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
            'scheduled_date' => $this->scheduled_date,
            'done_date' => $this->done_date,
            'personnel' => $this->personnel
        ];
    }
}
