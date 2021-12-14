<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Multitenancy\Models\Concerns\UsesLandlordConnection;

class Queue extends Model
{
    use HasFactory, UsesLandlordConnection;

    protected $fillable = ['status', 'payload', 'tenant_id'];
}
