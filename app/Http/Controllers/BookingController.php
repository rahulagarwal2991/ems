<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Services\BookingService;
use App\Http\Requests\StoreBookingRequest;
use App\Exceptions\EventFullyBookedException;
use App\Exceptions\DuplicateBookingException;

use Illuminate\Http\JsonResponse;

class BookingController extends Controller
{
    protected BookingService $bookingService;

    public function __construct(BookingService $bookingService)
    {
        $this->bookingService = $bookingService;
    }

    /**
     * Display a listing of all bookings.
     */
    public function index(): JsonResponse
    {
        $bookings = Booking::with(['event', 'attendee'])->get();
        return response()->json(['data' => $bookings]);
    }

    /**
     * Store a new booking
     */
    public function store(StoreBookingRequest $request): JsonResponse
    {
        try {
            $booking = $this->bookingService->createBooking($request->validated());
            return response()->json(['data' => $booking, 'message' => 'Booking successful'], 201);
        }catch (EventFullyBookedException | DuplicateBookingException $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Something went wrong'], 500);
        }
    }

    /**
     * Display a specific booking.
     */
    public function show(Booking $booking): JsonResponse
    {
        try {
            return response()->json(['data' => $booking->load(['event', 'attendee'])]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'No data found'], 400);
        }
    }

    /**
     * Delete a booking.
     */
    public function destroy(Booking $booking): JsonResponse
    {
        try {
            $booking->delete();
            return response()->json(['message' => 'Booking deleted successfully']);
        }catch (\Exception $e) {
            return response()->json(['error' => 'No data found'], 400);
        }
    }
}
