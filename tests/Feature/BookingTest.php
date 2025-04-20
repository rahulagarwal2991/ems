<?php

namespace Tests\Feature;

use Tests\TestCase;

class BookingTest extends TestCase
{
    public function test_user_can_book_event() {
        $event = Event::factory()->create(['capacity' => 2]);
        $attendee = Attendee::factory()->create();
    
        $response = $this->postJson('/api/bookings', [
            'event_id' => $event->id,
            'attendee_id' => $attendee->id
        ]);
    
        $response->assertStatus(201);
        $this->assertDatabaseHas('bookings', [
            'event_id' => $event->id,
            'attendee_id' => $attendee->id
        ]);
    }
}
