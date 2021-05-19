<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Maintenance extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'scheduled_date', 'done_date', 'personnel', 'inventory_id'];

    public function inventory()
    {
        return $this->belongsTo('App\Models\Inventory', 'inventory_id', 'id');
    }
}
