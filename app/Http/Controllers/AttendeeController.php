<?php

namespace App\Http\Controllers;

use App\Models\Attendee;
use Illuminate\Http\Request;

class AttendeeController extends Controller
{
    /**
     * Display a listing of the attendees.
     */
    public function index()
    {
        $attendees = Attendee::all();
        return response()->json(['data' => $attendees]);
    }

    /**
     * Store a newly created attendee in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:attendees,email',
        ]);

        $attendee = Attendee::create($validated);
        return response()->json(['data' => $attendee, 'message' => 'Attendee registered successfully'], 201);
    }

    /**
     * Display the specified attendee.
     */
    public function show(Attendee $attendee)
    {
        return response()->json(['data' => $attendee]);
    }

    /**
     * Update the specified attendee in storage.
     */
    public function update(Request $request, Attendee $attendee)
    {
        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:100',
            'email' => 'sometimes|required|email|unique:attendees,email,' . $attendee->id,
        ]);

        $attendee->update($validated);
        return response()->json(['data' => $attendee, 'message' => 'Attendee updated successfully']);
    }

    /**
     * Remove the specified attendee from storage.
     */
    public function destroy(Attendee $attendee)
    {
        $attendee->delete();
        return response()->json(['message' => 'Attendee deleted successfully']);
    }
}
