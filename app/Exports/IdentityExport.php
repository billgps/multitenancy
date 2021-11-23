<?php

namespace App\Exports;

use App\Models\Identity;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class IdentityExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Identity::all();
    }

    public function headings() : array 
    {
        return array_keys($this->collection()->first()->toArray());
    }
}
