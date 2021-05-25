<?php

namespace App\Exports;

use App\Device;
use Maatwebsite\Excel\Concerns\FromCollection;

class DeviceExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Device::all();
    }
}
