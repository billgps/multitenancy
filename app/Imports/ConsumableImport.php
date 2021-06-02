<?php

namespace App\Imports;

use App\Models\Consumable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ConsumableImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Consumable([
            'id' => $row['id'],
            'component' => $row['komponen'],
            'brand' => $row['merk'],
            'details' => $row['detail'],
            'inventory_id' => $row['inventory_id']
        ]);
    }
}
