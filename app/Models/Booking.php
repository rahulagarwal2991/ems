<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    //
    //
    protected $fillable = [
        'event_id', 'attendee_id'
    ];
}
