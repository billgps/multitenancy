<?php

namespace App\Imports;

use App\Models\Record;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class RecordImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Record([
            'id'    => $row['id'], 
            'cal_date'     => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['tanggal']),
            'label'    => $row['no_label'], 
            'calibration_status'     => $row['status_kalibrasi'],
            'vendor'    => 'PT Global Promedika Service',
            'certificate'     => null,
            'report'    => null, 
            'result'     => $row['hasil_kalibrasi'],
            'inventory_id'    => $row['inventory_id'],
        ]);
    }
}
