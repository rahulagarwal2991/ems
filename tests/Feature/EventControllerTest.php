<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Event;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EventControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_returns_all_events()
    {
        Event::factory()->count(2)->create();

        $response = $this->getJson('/api/v1/events');

        $response->assertStatus(200)->assertJsonCount(2, 'data');
    }

    public function test_can_store_event()
    {
        $data = [
            'title' => 'Test Event',
            'date' => now()->addDays(5)->format('Y-m-d'),
            'country' => 'India',
            'capacity' => 100
        ];

        $response = $this->postJson('/api/v1/events', $data);

        $response->assertStatus(201)->assertJsonFragment(['title' => 'Test Event']);
    }

    public function test_show_event()
    {
        $event = Event::factory()->create();

        $response = $this->getJson("/api/v1/events/{$event->id}");

        $response->assertStatus(200)->assertJsonFragment(['id' => $event->id]);
    }

    public function test_update_event()
    {
        $event = Event::factory()->create();

        $response = $this->putJson("/api/v1/events/{$event->id}", ['title' => 'Updated Event']);

        $response->assertStatus(200)->assertJsonFragment(['title' => 'Updated Event']);
    }

    public function test_delete_event()
    {
        $event = Event::factory()->create();

        $response = $this->deleteJson("/api/v1/events/{$event->id}");

        $response->assertStatus(200)->assertJsonFragment(['message' => 'Event deleted successfully']);
    }
}
