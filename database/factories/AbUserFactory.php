<?php

namespace Database\Factories;

use App\Models\AbUser;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AbUser>
 */
class AbUserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = AbUser::class;// damit Laravel später bei Seeder weiß, welche Factory verwendet soll
    public function definition(): array
    {
        return [
            'ab_name' => fake()->userName(),
            'ab_password' => Hash::make('password'),
            'ab_mail' => fake()->unique()->safeEmail(),
        ];
    }
}
