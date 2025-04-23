<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Services\EventService;
use App\Http\Requests\StoreEventRequest;
use App\Http\Requests\UpdateEventRequest;
use Illuminate\Http\JsonResponse;
use App\Exceptions\EventNotFoundException;
use App\Exceptions\EventOperationException;

class EventController extends Controller
{
    protected EventService $eventService;

    public function __construct(EventService $eventService)
    {
        $this->eventService = $eventService;
    }

    public function index(): JsonResponse
    {
        $events = $this->eventService->getAll();
        return response()->json(['data' => $events]);
    }

    public function store(StoreEventRequest $request): JsonResponse
    {
        $event = $this->eventService->create($request->validated());
        return response()->json(['data' => $event, 'message' => 'Event created successfully'], 201);
    }

    public function show(Event $event): JsonResponse
    {
        try {
            return response()->json(['data' => $this->eventService->show($event)]);
        } catch (\Exception $e) {
            throw new EventNotFoundException();
        }
    }

    public function update(UpdateEventRequest $request, Event $event): JsonResponse
    {
        try {
            $event = $this->eventService->update($event, $request->validated());
            return response()->json(['data' => $event, 'message' => 'Event updated successfully']);
        } catch (\Exception $e) {
            throw new EventOperationException();
        }
    }

    public function destroy(Event $event): JsonResponse
    {
        try {
            $this->eventService->delete($event);
            return response()->json(['message' => 'Event deleted successfully']);
        } catch (\Exception $e) {
            throw new EventOperationException();
        }
    }
}
