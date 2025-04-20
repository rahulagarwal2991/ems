<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    /**
     * Display a listing of the events.
     */
    public function index()
    {
        $events = Event::all();
        return response()->json(['data' => $events]);
    }

    /**
     * Store a newly created event in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'date' => 'required|date',
            'country' => 'required|string',
            'capacity' => 'required|integer|min:1',
        ]);

        $event = Event::create($validated);
        return response()->json(['data' => $event, 'message' => 'Event created successfully'], 201);
    }

    /**
     * Display the specified event.
     */
    public function show(Event $event)
    {
        return response()->json(['data' => $event]);
    }

    /**
     * Update the specified event in storage.
     */
    public function update(Request $request, Event $event)
    {
        $validated = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'date' => 'sometimes|required|date',
            'country' => 'sometimes|required|string',
            'capacity' => 'sometimes|required|integer|min:1',
        ]);

        $event->update($validated);
        return response()->json(['data' => $event, 'message' => 'Event updated successfully']);
    }

    /**
     * Remove the specified event from storage.
     */
    public function destroy(Event $event)
    {
        $event->delete();
        return response()->json(['message' => 'Event deleted successfully']);
    }
}
