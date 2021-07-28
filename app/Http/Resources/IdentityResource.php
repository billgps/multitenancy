<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class IdentityResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $device = $this->whenLoaded('device');
        $brand = $this->whenLoaded('brand');

        return [
            'id' => $this->id,
            'device' => new DeviceResource($device),
            'brand' => new BrandResource($brand),
            'model' => $this->model,
        ];
    }
}
