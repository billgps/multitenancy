<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Multitenancy\Models\Concerns\UsesTenantConnection;

class Consumable extends Model
{
    use HasFactory, UsesTenantConnection;

    protected $fillable = ['id', 'component', 'brand', 'details', 'inventory_id'];

    public function inventory()
    {
        return $this->belongsTo('App\Models\Inventory', 'inventory_id', 'id')->withDefault();
    }
}
