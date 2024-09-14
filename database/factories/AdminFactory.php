<?php

namespace Database\Factories;

use App\Models\Admin;
use Illuminate\Database\Eloquent\Factories\Factory;

class AdminFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Admin::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'to_id' => Arr::random([$user_1, $user_2]),
            'from_id' => Arr::random([$user_1, $user_2]),
            'body' => $title,
            'read' => rand(0, 1),
            'messenger_user_id' => $messenger_user_id,
            'created_at' => $this->faker->dateTimeBetween($startDate = '-1 years', $endDate = 'now', $timezone = null),
        ];
    }
}
