<?php

namespace App\Exports;

use App\Models\Record;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class RecordExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Record::all();
    }

    public function headings() : array {
        return array_keys($this->collection()->first()->toArray());
    }
}
