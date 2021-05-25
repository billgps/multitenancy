<?php

namespace App\Imports;

use App\Models\Inventory;
use Maatwebsite\Excel\Concerns\ToModel;

class InventoryImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Inventory([
            // 'id'     => $row['id'],
            'barcode'     => $row['barcode'],
            'device_id'    => $row['nama'], 
            'identity_id'     => $row['tipe'],
            'brand_id'    => $row['merk'],
            'room_id'     => $row['ruangan'],
            'serial'    => $row['serial_number'], 
            // 'picture'     => 'null',
            'supplier'    => $row['supplier'],
        ]);
    }
}
