<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Complain extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'date_time', 'room_id', 'description', 'replied','serialnumber'];

    /**
     * Get the response associated with the Complain
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function response()
    {
        return $this->hasOne('App\Models\Response')->withDefault([
            'progress_status' => 'Pending',
            'user_id' => null,
            'created_at' => 0
        ]);
    }

    /**
     * Get the user associated with the Complain
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    /**
     * Get the room associated with the Complain
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function room()
    {
        return $this->belongsTo('App\Models\Room');
    }
}
