<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Multitenancy\Models\Concerns\UsesTenantConnection;

class Condition extends Model
{
    use HasFactory, UsesTenantConnection;

    protected $fillable = ['id', 'event_date', 'event', 'status', 'user_id', 'worksheet', 'inventory_id'];

    public function inventory()
    {
        return $this->belongsTo('App\Models\Inventory', 'inventory_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }
}
