<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class InventoryResource extends JsonResource
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
        $identity = $this->whenLoaded('identity');
        $room = $this->whenLoaded('room');
        $latest_record = $this->whenLoaded('latest_record');
        $records = $this->whenLoaded('records');
        $latest_condition = $this->whenLoaded('latest_condition');
        $conditions = $this->whenLoaded('conditions');
        $maintenances = $this->whenLoaded('maintenances');
        $asset = $this->whenLoaded('asset');

        return [
            'id' => $this->id,
            'barcode' => $this->barcode,
            'device' => new DeviceResource($device),
            'identity' => new IdentityResource($identity),
            'room' => new RoomResource($room),
            'serial' => $this->serial,
            'picture' => env('APP_URL').$this->picture,
            'latest_record' => new RecordResource($latest_record),
            'records' => RecordResource::collection($records), 
            'latest_condition' => new ConditionResource($latest_condition),
            'conditions' => ConditionResource::collection($conditions),
            'maintenances' => MaintenanceResource::collection($maintenances),
            'asset' => new AssetResource($asset)                    
        ];
    }
}
