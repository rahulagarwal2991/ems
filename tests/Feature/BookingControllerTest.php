<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Booking;
use App\Models\Event;
use App\Models\Attendee;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BookingControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_list_bookings()
    {
        Booking::factory()->count(2)->create();

        $response = $this->getJson('/api/v1/bookings');

        $response->assertStatus(200)->assertJsonStructure(['data']);
    }

    public function test_can_store_booking()
    {
        $event = Event::factory()->create();
        $attendee = Attendee::factory()->create();

        $response = $this->postJson('/api/v1/bookings', [
            'event_id' => $event->id,
            'attendee_id' => $attendee->id,
        ]);

        $response->assertStatus(201)->assertJsonStructure(['data']);
    }

    public function test_show_booking()
    {
        $booking = Booking::factory()->create();

        $response = $this->getJson("/api/v1/bookings/{$booking->id}");

        $response->assertStatus(200)->assertJsonStructure(['data']);
    }

    public function test_delete_booking()
    {
        $booking = Booking::factory()->create();

        $response = $this->deleteJson("/api/v1/bookings/{$booking->id}");

        $response->assertStatus(200)
                 ->assertJsonFragment(['message' => 'Booking deleted successfully']);
    }
}
