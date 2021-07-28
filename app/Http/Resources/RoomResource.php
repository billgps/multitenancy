<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RoomResource extends JsonResource
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
            'room_name' => $this->room_name,
            'room_pic' => $this->room_pic,
            'inventories' => InventoryResource::collection($inventories)
        ];
    }
}
