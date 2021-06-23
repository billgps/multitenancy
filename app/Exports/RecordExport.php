<?php

namespace App\Exports;

use App\Record;
use Maatwebsite\Excel\Concerns\FromCollection;

class RecordExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Record::all();
    }
}
