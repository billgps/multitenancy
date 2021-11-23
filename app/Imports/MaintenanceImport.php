<?php

namespace App\Imports;

use App\Models\Maintenance;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class MaintenanceImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Maintenance([
            // 'id'     => $row['id'],
            'scheduled_date'     => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['tanggal_jadwal']),
            'done_date'     => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['tanggal_selesai']),
            'personnel'     => $row['personel'],
            'inventory_id' => $row['inventory_id']
        ]);
    }
}
