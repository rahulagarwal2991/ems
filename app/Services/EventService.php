<?php

namespace App\Services;

use App\Models\Event;
use App\Exceptions\EventNotFoundException;
use App\Exceptions\EventOperationException;

class EventService
{
    public function getAll()
    {
        return Event::all();
    }

    public function create(array $data): Event
    {
        return Event::create($data);
    }

    public function update(Event $event, array $data): Event
    {
        $event->update($data);
        return $event;
    }

    public function delete(Event $event): void
    {
        if (!$event->delete()) {
            throw new EventOperationException('Event deletion failed.');
        }
    }

    public function show(Event $event): Event
    {
        return $event;
    }
}
