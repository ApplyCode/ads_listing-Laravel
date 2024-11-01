<?php

namespace Modules\Ad\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Ad\Entities\Ad;

class AdFeatureFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \Modules\Ad\Entities\AdFeature::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        // Get a random Ad instance
        $ad = Ad::inRandomOrder()->first();

        return [
            'ad_id' => $ad->id, // Associate the feature with a random Ad
            'name' => $this->faker->sentence(), // Generate a random feature name
        ];
    }
}
