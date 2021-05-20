<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'brand', 'origin'];

    public function identities()
    {
        return $this->hasMany('App\Models\Identity', 'brand_id', 'id');
    }
}
