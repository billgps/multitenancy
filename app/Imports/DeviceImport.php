<?php

namespace App\Imports;

use App\Models\Device;
use App\Models\Nomenclature;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class DeviceImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        // $result = Nomenclature::search($row['nama_alat'])->within('standard_name')->get();
        $result = DB::connection('host')->select('SELECT `id` FROM nomenclatures WHERE 
                    MATCH(`standard_name`) AGAINST ("'.$row['nama_alat'].'" 
                    IN BOOLEAN MODE) > 2');

        if (count($result) > 1 || count($result) < 1) {
            $nomenclatureID = null;
        } else {
            $nomenclatureID = $result[0]->id;
        }

        return new Device([
            'id' => $row['id'],
            'standard_name' => $row['nama_alat'],
            'nomenclature_id' =>  $nomenclatureID,
        ]);
    }
}
