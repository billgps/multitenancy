<?php

namespace App\Models;

use Spatie\Multitenancy\Models\Concerns\UsesTenantConnection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    use HasFactory, UsesTenantConnection;

    protected $fillable = ['id', 'standard_name', 'nomenclature_id'];

    public function inventories()
    {
        return $this->hasMany('App\Models\Inventory', 'device_id', 'id');
    }

    public function identities()
    {
        return $this->hasMany('App\Models\Identity', 'device_id', 'id');
    }

    /**
     * Get the nomenclature that owns the Device
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function nomenclature()
    {
        return $this->belongsTo(Nomenclature::class, 'nomenclature_id', 'id');
    }
}
