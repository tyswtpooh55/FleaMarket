<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $dummyImgDir = storage_path('app/public/images/dummyImages');
        $images = glob($dummyImgDir . '/*.{jpg,jpeg,png,gif}', GLOB_BRACE);

        $randomImage = $images ? $images[array_rand($images)] : null;


        $imgUrl = $randomImage ? str_replace(storage_path('app/public/'), '', $randomImage) : null;

        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => null,
            'password' => bcrypt('pass1234'), // password
            'img_url' => $imgUrl,
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}
