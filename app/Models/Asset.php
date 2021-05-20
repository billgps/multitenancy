<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'price', 'year_purchased', 'inventory_id'];

    public function inventory()
    {
        return $this->hasOne('App\Models\Inventory', 'id', 'inventory_id');
    }
}
