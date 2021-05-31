<?php

namespace App\Imports;

use App\Models\Condition;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ConditionImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Condition([
            'id' => $row['id'],
            'event_date' => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['tanggal_kejadian']),
            'event' => $row['keterangan'],
            'status' => $row['kondisi_alat'],
            'user_id' => $row['user_id'],
            'worksheet' => $row['lembar_kerja'],
            'inventory_id' => $row['inventory_id']
        ]);
    }
}
