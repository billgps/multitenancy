<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ConsumableResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $inventory = $this->whenLoaded('inventory');

        return [
            'id' => $this->id,
            'component' => $this->id,
            'brand' => $this->brand,
            'details' => $this->details,
            'inventory' => new InventoryResource($inventory)
        ];
    }
}
