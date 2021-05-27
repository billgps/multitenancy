<?php

namespace App\Imports;

use App\Models\Identity;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class IdentityImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Identity([
            'id' => $row['id'],
            'device_id' => $row['id_nama_alat'],
            'brand_id' => $row['id_merk'],
            'model' => $row['model']
        ]);
    }
}
