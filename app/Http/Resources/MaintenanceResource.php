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
            'ID' => $this->id,
            'Tanggal Dijadwalkan' => $this->scheduled_date,
            'Tanggal Selesai' => $this->done_date,
            'Personel' => $this->personnel
        ];
    }
}
