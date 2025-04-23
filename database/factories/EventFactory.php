<?php
namespace Database\Factories;

use App\Models\Event;
use Illuminate\Database\Eloquent\Factories\Factory;

class EventFactory extends Factory
{
    protected $model = Event::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(3),
            'date' => $this->faker->date(),
            'country' => $this->faker->country(),
            'capacity' => $this->faker->numberBetween(10, 100),
        ];
    }
}
