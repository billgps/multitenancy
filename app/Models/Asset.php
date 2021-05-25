<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Multitenancy\Models\Concerns\UsesTenantConnection;
use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    use HasFactory, UsesTenantConnection;

    protected $fillable = ['id', 'price', 'year_purchased', 'inventory_id'];

    public function inventory()
    {
        return $this->hasOne('App\Models\Inventory', 'id', 'inventory_id');
    }
}
