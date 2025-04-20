<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Event;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    /**
     * Display a listing of all bookings.
     */
    public function index()
    {
        $bookings = Booking::with(['event', 'attendee'])->get();
        return response()->json(['data' => $bookings]);
    }

    /**
     * Store a new booking (via API).
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'event_id' => 'required|exists:events,id',
            'attendee_id' => 'required|exists:attendees,id'
        ]);

        $event = Event::findOrFail($validated['event_id']);
        $currentCount = Booking::where('event_id', $event->id)->count();

        if ($currentCount >= $event->capacity) {
            return response()->json(['error' => 'Event is fully booked'], 400);
        }

        $existingBooking = Booking::where($validated)->first();
        if ($existingBooking) {
            return response()->json(['error' => 'Attendee already booked for this event'], 409);
        }

        $booking = Booking::create($validated);
        return response()->json(['data' => $booking, 'message' => 'Booking successful'], 201);
    }

    /**
     * Display a specific booking.
     */
    public function show(Booking $booking)
    {
        return response()->json(['data' => $booking->load(['event', 'attendee'])]);
    }

    /**
     * Update an existing booking (event or attendee reassignment).
     */
    public function update(Request $request, Booking $booking)
    {
        $validated = $request->validate([
            'event_id' => 'sometimes|required|exists:events,id',
            'attendee_id' => 'sometimes|required|exists:attendees,id'
        ]);

        if (isset($validated['event_id'])) {
            $event = Event::findOrFail($validated['event_id']);
            $count = Booking::where('event_id', $validated['event_id'])->count();

            if ($count >= $event->capacity && $booking->event_id !== $validated['event_id']) {
                return response()->json(['error' => 'New event is already fully booked'], 400);
            }
        }

        $booking->update($validated);
        return response()->json(['data' => $booking, 'message' => 'Booking updated successfully']);
    }

    /**
     * Delete a booking.
     */
    public function destroy(Booking $booking)
    {
        $booking->delete();
        return response()->json(['message' => 'Booking deleted successfully']);
    }
}