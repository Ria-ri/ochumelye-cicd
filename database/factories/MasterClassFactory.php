<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\MasterClass;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<MasterClass>
 */
class MasterClassFactory extends Factory
{
    protected $model = MasterClass::class;

    public function definition(): array
    {
        $date = fake()->dateTimeBetween('+1 day', '+1 month');
        $timeSlots = ['9-11', '11-13', '13-15', '15-17'];

        return [
            'category_id' => Category::factory(),
            'master_id' => User::factory()->master(),
            'title' => fake()->sentence(3),
            'description' => fake()->paragraph(),
            'date' => $date->format('Y-m-d'),
            'time_slot' => fake()->randomElement($timeSlots),
            'capacity' => fake()->numberBetween(1, 20),
            'cost' => fake()->numberBetween(100, 5000),
        ];
    }
}
