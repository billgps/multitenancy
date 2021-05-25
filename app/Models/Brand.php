<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Multitenancy\Models\Concerns\UsesTenantConnection;

class Brand extends Model
{
    use HasFactory, UsesTenantConnection;

    protected $fillable = ['id', 'brand', 'origin'];

    public function identities()
    {
        return $this->hasMany('App\Models\Identity', 'brand_id', 'id');
    }
}
