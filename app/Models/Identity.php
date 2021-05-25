<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Multitenancy\Models\Concerns\UsesTenantConnection;

class Identity extends Model
{
    use HasFactory, UsesTenantConnection;

    protected $fillable = ['id', 'device_id', 'brand_id', 'model', 'manual', 'procedure'];

    public function inventories()
    {
        return $this->hasMany('App\Models\Inventory');
    }

    public function device()
    {
        return $this->belongsTo('App\Models\Device', 'device_id', 'id');
    }

    public function brand()
    {
        return $this->belongsTo('App\Models\Brand', 'brand_id', 'id');
    }
}
