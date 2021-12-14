<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;

    protected $fillable = ['facility_code', 'name', 'order_no', 'started_at', 'finished_at', 'active_at', 'is_active', 'aspak_id'];

    public function records ()
    {
        return $this->hasMany(Record::class);
    }

    public static function active () : Activity
    {
        return Activity::where('is_active', true)->first();
    }
}
