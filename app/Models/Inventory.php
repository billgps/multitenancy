<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Multitenancy\Models\Concerns\UsesTenantConnection;
use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory, UsesTenantConnection;

    protected $fillable = ['id', 'barcode', 'device_id', 'identity_id', 'brand_id', 'room_id', 'serial', 'picture', 'supplier', 'price', 'year_purchased', 'penyusutan'];

    /**
     * Get the indexable data array for the model.
     *
     * @return array
     */
    public function toSearchableArray()
    {
        $array = $this->toArray();
            
        return array('barcode' => $array['barcode'],'serial' => $array['serial']);
    }

    public function records()
    {
        return $this->hasMany('App\Models\Record', 'inventory_id', 'id')->orderBy('created_at', 'desc');
    }

    public function maintenances()
    {
        return $this->hasMany('App\Models\Maintenance', 'inventory_id', 'id');
    }

    public function consumables()
    {
        return $this->hasMany('App\Models\Consumable', 'inventory_id', 'id');
    }

    public function conditions()
    {
        return $this->hasMany('App\Models\Condition', 'inventory_id', 'id');
    }

    public function device()
    {
        return $this->belongsTo('App\Models\Device', 'device_id', 'id')->withDefault();
    }

    public function identity()
    {
        return $this->belongsTo('App\Models\Identity', 'identity_id', 'id')->withDefault();
    }

    public function brand()
    {
        return $this->belongsTo('App\Models\Brand', 'brand_id', 'id')->withDefault();
    }

    public function room()
    {
        return $this->belongsTo('App\Models\Room', 'room_id', 'id')->withDefault();
    }

    public function asset()
    {
        return $this->hasOne('App\Models\Asset', 'inventory_id', 'id')->withDefault([
            'year_purchased' => '-',
            'price' => '-'
        ]);

        // return $this->hasOne('App\Models\Asset', 'inventory_id', 'id');
    }

    public function latest_condition()
    {
        return $this->hasOne('App\Models\Condition', 'inventory_id', 'id')->latest('event_date')->withDefault([
            'calibration_status' => 'Belum Update'
        ]);
    }

    public function latest_record()
    {
        return $this->hasOne('App\Models\Record', 'inventory_id', 'id')->latest('cal_date')->withDefault([
            'calibration_status' => 'Belum Update'
        ]);
    }

    public function latest_maintenance()
    {
        return $this->hasOne('App\Models\Maintenance', 'inventory_id', 'id')->latest()->withDefault([
            'status' => 'Belum Update'
        ]);
    }
}
