<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'standard_name', 'alias_name', 'risk_level', 'ipm_frequency'];

    public function inventories()
    {
        return $this->hasMany('App\Models\Inventory', 'device_id', 'id');
    }

    public function identities()
    {
        return $this->hasMany('App\Models\Identity', 'device_id', 'id');
    }
}
