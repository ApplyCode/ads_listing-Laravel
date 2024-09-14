<?php

namespace Database\Factories;

use App\Models\MessengerUser;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Messenger>
 */
class MessengerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = $this->faker->sentence($nbWords = 10, $variableNbWords = true);
        $user_1 = 1;
        $user_2 = Arr::random([2, 3]);

        // $user_2 = Arr::random([15, 16]);
        // $user_2 = Candidate::inRandomOrder()->value('id');
        // $chat_id = MessengerUser::where('company_id', $user_1)->where('candidate_id', $user_2)->value('id');

        $messenger_user_id = MessengerUser::where(function ($query) use ($user_1, $user_2) {
            $query->where(function ($q) use ($user_1, $user_2) {
                $q->where('from_id', $user_1);
                $q->where('to_id', $user_2);
            })
                ->orWhere(function ($q) use ($user_1, $user_2) {
                    $q->where('to_id', $user_1);
                    $q->where('from_id', $user_2);
                });
        })->value('id');

        return [

        ];
    }
}
