<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Booking extends Model
{
    use HasFactory;
    //
    //
    protected $fillable = [
        'event_id', 'attendee_id'
    ];

    // Define the relationship with the Event model
    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    // Define the relationship with the Attendee model
    public function attendee()
    {
        return $this->belongsTo(Attendee::class);
    }
}
