<?php

namespace App\Imports;

use App\Models\Brand;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class BrandImport implements ToModel, WithHeadingRow, WithValidation
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Brand([
            'id' => $row['id'],
            'brand' => $row['merk'],
            'origin' => $row['asal']
        ]);
    }

    public function rules(): array
    {
        return [
            '*.id' => ['required', 'integer', 'unique:brands'],
            '*.merk' => ['required', 'max:255'],
            // '*.merk' => ['required', 'max:255', Rule::unique('brands', 'brand')],
        ];
    }
}
