<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $gender = (bool) rand(0,1) ? 'male' : 'female';
        return [
            'name' => fake()->firstName($gender),
            'surname' => fake()->lastName($gender),
            'email' => fake()->unique()->freeEmail(),
            'email_verified_at' => now(),
            'phone' => fake()->unique()->e164PhoneNumber(),
            'birthdate' => fake()->dateTimeBetween('-70 years', '-18 years')->format('Y-m-d'),
            'avatar' => 'public/users/avatars/VRbJ1KBHaKOZXrH0_1702680330.jpg',
            'password' => Hash::make('test1234'),
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
