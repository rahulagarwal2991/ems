<?php

namespace App\Services;

use App\Models\Attendee;
use App\Exceptions\AttendeeNotFoundException;
use App\Exceptions\AttendeeOperationException;

class AttendeeService
{
    public function getAll()
    {
        return Attendee::all();
    }

    public function create(array $data)
    {
        try {
            return Attendee::create($data);
        } catch (\Exception $e) {
            throw new AttendeeOperationException('Unable to create attendee.');
        }
    }

    public function update(Attendee $attendee, array $data)
    {
        try {
            $attendee->update($data);
            return $attendee;
        } catch (\Exception $e) {
            throw new AttendeeOperationException('Unable to update attendee.');
        }
    }

    public function delete(Attendee $attendee): void
    {
        try {
            $attendee->delete();
        } catch (\Exception $e) {
            throw new AttendeeOperationException('Unable to delete attendee.');
        }
    }
}
