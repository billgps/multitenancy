<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\DatabaseNotification;
use Spatie\Multitenancy\Models\Concerns\UsesTenantConnection;

class Notification extends DatabaseNotification
{
    use HasFactory;
    use UsesTenantConnection;
}
