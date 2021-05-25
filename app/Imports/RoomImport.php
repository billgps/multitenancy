<?php

namespace App\Imports;

use App\Models\Room;
use Maatwebsite\Excel\Concerns\ToModel;

class RoomImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Room([
            'id' => $row['id'],
            'unit' => $row['nama_unit'],
            'building' => $row['nama_gedung'],
            'room_name' => $row['nama_ruangan'],
            'room_pic' => $row['pic_ruangan'],
        ]);
    }
}
