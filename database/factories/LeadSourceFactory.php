<?php

namespace Database\Factories;

use Crater\Models\LeadSource;
use Illuminate\Database\Eloquent\Factories\Factory;

class LeadSourceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = LeadSource::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->word(),
        ];
    }
}
