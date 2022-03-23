<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Maintenance extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'inventory_id', 'user_id', 'raw', 'result'];

    public function inventory()
    {
        return $this->belongsTo('App\Models\Inventory', 'inventory_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }
}
