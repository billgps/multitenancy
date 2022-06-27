<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Response extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'complain_id', 'progress_status', 'serialnumber', 'description', 'resPic'];

    /**
     * Get the complain associated with the Response
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function complain()
    {
        return $this->belongsTo('App\Models\Complain');
    }

    /**
     * Get the user associated with the Response
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User')->withDefault();
    }
}
