<?php

namespace Database\Factories;

use App\Models\Condition;
use App\Models\Item;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ItemFactory extends Factory
{
    protected $model = Item::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->word(),
            'brand' => $this->faker->company(),
            'price' => $this->faker->numberBetween(100, 50000),
            'description' => $this->faker->realText(),
            'seller_id' => User::inRandomOrder()
                ->first()
                ->id,
            'condition_id' => Condition::inRandomOrder()
                ->first()
                ->id,
        ];
    }
}
