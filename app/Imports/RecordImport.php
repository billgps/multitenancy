<?php

namespace App\Imports;

use App\Models\Record;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class RecordImport implements ToModel, WithHeadingRow, WithValidation
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Record([
            // 'id'    => $row['id'], 
            'cal_date'     => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject(intval($row['tanggal'])),
            'label'    => $row['no_label'], 
            'calibration_status'     => $row['status_kalibrasi'],
            'vendor'    => 'PT Global Promedika Service',
            'certificate'     => null,
            'report'    => null, 
            'result'     => $row['hasil_kalibrasi'],
            'inventory_id'    => $row['inventory_id'],
        ]);
    }

    public function rules(): array
    {
        return [
            '*.tanggal' => ['required'],
            '*.no_label' => ['required', 'max:255'],
            '*.status_kalibrasi' => ['required', 'max:255'],
            '*.hasil_kalibrasi' => ['required', 'max:255'],
            '*.inventory_id' => ['required', 'integer']
        ];
    }
}
