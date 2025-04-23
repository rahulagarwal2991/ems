<?php

namespace App\Services;

use App\Models\Booking;
use App\Models\Event;
use App\Exceptions\EventFullyBookedException;
use App\Exceptions\DuplicateBookingException;

class BookingService
{
    /**
     * Create a new booking.
     *
     * @param array $data
     * @return Booking
     * @throws EventFullyBookedException
     * @throws DuplicateBookingException
     */
    public function createBooking(array $data) : Booking
    {
        $event = Event::findOrFail($data['event_id']);

        if ($event->count() >= $event->capacity) {
            throw new EventFullyBookedException();
        }

        $existing = Booking::where($data)->first();
        if ($existing) {
            throw new DuplicateBookingException();
        }

        return Booking::create($data);
    }
}
