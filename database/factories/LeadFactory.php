<?php

namespace Database\Factories;

use Crater\Models\Lead;
use Illuminate\Database\Eloquent\Factories\Factory;

class LeadFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Lead::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->safeEmail(),
            'phone' => $this->faker->phoneNumber(),
            'location' => $this->faker->words(3, true),
            'interests' => $this->faker->words(3, true),
            'message' => $this->faker->sentence(),
            'language' => $this->faker->locale(),
            'lead_source_id' => 1,
        ];
    }
}
