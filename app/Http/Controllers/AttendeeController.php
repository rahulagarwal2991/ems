<?php

namespace App\Http\Controllers;

use App\Models\Attendee;
use App\Services\AttendeeService;
use App\Http\Requests\StoreAttendeeRequest;
use App\Http\Requests\UpdateAttendeeRequest;
use App\Exceptions\AttendeeNotFoundException;
use App\Exceptions\AttendeeOperationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;

class AttendeeController extends Controller
{
    protected AttendeeService $attendeeService;

    public function __construct(AttendeeService $attendeeService)
    {
        $this->attendeeService = $attendeeService;
    }

    public function index(): JsonResponse
    {
        try {
            $attendees = $this->attendeeService->getAll();
            return response()->json(['data' => $attendees]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Unable to fetch attendees'], 500);
        }
    }

    public function store(StoreAttendeeRequest $request): JsonResponse
    {
        try {
            $attendee = $this->attendeeService->create($request->validated());
            return response()->json(['data' => $attendee, 'message' => 'Attendee registered successfully'], 201);
        } catch (AttendeeOperationException $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function show(Attendee $attendee): JsonResponse
    {
        try {
            return response()->json(['data' => $attendee]);
        } catch (ModelNotFoundException $e) {
            throw new AttendeeNotFoundException();
        } catch (AttendeeOperationException $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Something went wrong'], 500);
        }
    }

    public function update(UpdateAttendeeRequest $request, Attendee $attendee): JsonResponse
    {
        try {
            $updated = $this->attendeeService->update($attendee, $request->validated());
            return response()->json(['data' => $updated, 'message' => 'Attendee updated successfully']);
        } catch (AttendeeOperationException $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function destroy(Attendee $attendee): JsonResponse
    {
        try {
            $this->attendeeService->delete($attendee);
            return response()->json(['message' => 'Attendee deleted successfully']);
        } catch (AttendeeOperationException $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}
