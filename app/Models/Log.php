<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Multitenancy\Models\Concerns\UsesLandlordConnection;

class Log extends Model
{
    use HasFactory, UsesLandlordConnection;

    protected $fillable = ['queue_id', 'response', 'error'];

    /**
     * Get the queue that owns the Log
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function queue()
    {
        return $this->belongsTo(Queue::class);
    }
}
