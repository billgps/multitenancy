<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'unit', 'building', 'room_name', 'room_pic'];

    public function inventories()
    {
        return $this->hasMany('App\Models\Inventory', 'room_id', 'id');
    }
}
