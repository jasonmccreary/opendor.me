<?php

namespace Database\Factories;

use App\Models\Repository;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition(): array
    {
        return [
            'id' => $this->faker->unique->randomNumber(8),
            'name' => $this->faker->unique->userName,
            'full_name' => $this->faker->unique->name,
            'email' => $this->faker->unique()->safeEmail,
            'email_verified_at' => null,
            'remember_token' => Str::random(10),
            'registered_at' => null,
        ];
    }

    public function registered(): self
    {
        return $this->state([
            'registered_at' => now(),
            'email_verified_at' => now(),
            'github_access_token' => Str::random(),
        ]);
    }

    public function withContributions(int $count): self
    {
        return $this->afterCreating(fn (User $user) => $user->contributions()->sync(Repository::factory()->count($count)->create()));
    }
}
