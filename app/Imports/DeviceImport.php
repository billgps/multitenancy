<?php

namespace App\Imports;

use App\Models\Device;
use Maatwebsite\Excel\Concerns\ToModel;

class DeviceImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Device([
            'id' => $row['id'],
            'standard_name' => $row['nama_alat'],
            'alias_name' => $row['nama_alias'],
            'risk_level' => $row['risk_level'],
            'ipm_frequency' => $row['ipm_frequency'],
        ]);
    }
}
