<?php

namespace App\Imports;

use App\Models\Asset;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class AssetImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Asset([
            'id' => $row['id'],
            'price' => $row['harga'],
            'year_purchased' => $row['tahun_pembelian'],
            'inventory_id' => $row['inventory_id']
        ]);
    }
}
