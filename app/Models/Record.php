<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Multitenancy\Models\Concerns\UsesTenantConnection;

class Record extends Model
{
    use HasFactory, UsesTenantConnection;

    protected $fillable = [
        'id',
        'cal_date',
        'label',
        'calibration_status',
        'result',
        'inventory_id',
        'vendor',
        'report',
        'certificate'
    ];

    public function inventory()
    {
        return $this->belongsTo('App\Models\Inventory', 'inventory_id', 'id');
    }

    public function activity()
    {
        return $this->belongsTo(Activity::class);
    }
}
