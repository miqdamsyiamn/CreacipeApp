<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            // 'name' => fake()->name(),
            // 'email' => fake()->unique()->safeEmail(),
            'name' => $this->faker->text(20), // Batasi panjang maksimum 20 karakter
            'email' => $this->faker->unique()->safeEmail(),
            'password' => Hash::make('password'), // Default password
            'role_id' => 3, // Default role: Member
            'status_id' => 1, // Default status: Active
            'created_at' => now(),
            'updated_at' => now(),
            // 'email_verified_at' => now(),
            // 'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            // 'remember_token' => Str::random(10),
        ];
    }

    /**
     * Define state for an editor role.
     *
     * @return static
     */
    public function editor()
    {
        return $this->state(fn (array $attributes) => [
            'role_id' => 2, // Role: Editor
        ]);
    }

    /**
     * Define state for an admin role.
     *
     * @return static
     */
    public function admin()
    {
        return $this->state(fn (array $attributes) => [
            'role_id' => 1, // Role: Admin
        ]);
    }

    /**
     * Define state for inactive status.
     *
     * @return static
     */
    public function inactive()
    {
        return $this->state(fn (array $attributes) => [
            'status_id' => 2, // Status: Inactive
        ]);
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return static
     */
    // public function unverified()
    // {
    //     return $this->state(fn (array $attributes) => [
    //         'email_verified_at' => null,
    //     ]);
    // }
}
