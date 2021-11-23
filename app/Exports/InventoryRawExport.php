<?php

namespace App\Exports;

use App\Models\Inventory;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class InventoryRawExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Inventory::all();
    }

    public function headings() : array {
        return array_keys($this->collection()->first()->toArray());

        // return [
        //     'id',
        //     'barcode',
        //     'device_id',
        //     'identity_id',
        //     'room_id',
        //     'serial',
        //     'picture',
        //     'supplier',
        //     'created_at',
        //     'updated_at'
        // ];
    }
}
