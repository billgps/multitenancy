<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RecordResource extends JsonResource
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
            'Tanggal Kalibrasi' => $this->cal_date,
            'Label' => $this->label,
            'Report' => $this->report,
            'Certificate' => $this->certificate,
            'Hasil Kalibrasi' => $this->result,
            'Status Kalirbasi' => $this->calibration_status
        ];
    }
}
