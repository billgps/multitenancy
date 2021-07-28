<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AssetResource extends JsonResource
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
            'price' => $this->price,
            'year_purchased' => $this->year_purchased,
            'inventory' => new InventoryResource($inventory)
        ];
    }
}
