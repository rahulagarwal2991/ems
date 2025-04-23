<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Attendee;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AttendeeControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_get_all_attendees()
    {
        Attendee::factory()->count(3)->create();

        $response = $this->getJson('/api/v1/attendees');

        $response->assertStatus(200)
                 ->assertJsonCount(3, 'data');
    }

    public function test_can_create_attendee()
    {
        $data = ['name' => 'John Doe', 'email' => 'john@example.com'];

        $response = $this->postJson('/api/v1/attendees', $data);

        $response->assertStatus(201)
                 ->assertJsonFragment(['email' => 'john@example.com']);
    }

    public function test_show_attendee()
    {
        $attendee = Attendee::factory()->create();

        $response = $this->getJson("/api/v1/attendees/{$attendee->id}");

        $response->assertStatus(200)
                 ->assertJsonFragment(['id' => $attendee->id]);
    }

    public function test_update_attendee()
    {
        $attendee = Attendee::factory()->create();

        $response = $this->putJson("/api/v1/attendees/{$attendee->id}", [
            'name' => 'Updated Name',
        ]);

        $response->assertStatus(200)
                 ->assertJsonFragment(['name' => 'Updated Name']);
    }

    public function test_delete_attendee()
    {
        $attendee = Attendee::factory()->create();

        $response = $this->deleteJson("/api/v1/attendees/{$attendee->id}");

        $response->assertStatus(200)
                 ->assertJsonFragment(['message' => 'Attendee deleted successfully']);
    }
}
