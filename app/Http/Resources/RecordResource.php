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
            'id' => $this->id,
            'cal_date' => $this->cal_date,
            'label' => $this->label,
            'report' => env('APP_URL').$this->report,
            'certificate' => env('APP_URL').$this->certificate,
            'result' => $this->result,
            'calibration_status' => $this->calibration_status
        ];
    }
}
