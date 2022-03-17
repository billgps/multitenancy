<?php

namespace App\Imports;

use App\Models\Device;
use App\Models\Nomenclature;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class DeviceImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $collection)
    {
        //
    }
}
