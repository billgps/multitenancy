<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DeviceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $inventories = $this->whenLoaded('inventories');

        return [
            'id' => $this->id,
            'standard_name' => $this->standard_name,
            'inventories' => InventoryResource::collection($inventories)
        ];
    }
}
