<?php

namespace TomatoPHP\FilamentAccounts\Tests\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use TomatoPHP\FilamentAccounts\Tests\Models\Account;

class AccountFactory extends Factory
{
    protected $model = Account::class;

    public function definition(): array
    {
        $email = $this->faker->unique()->safeEmail();

        return [
            'name' => $this->faker->name(),
            'type' => 'account',
            'address' => $this->faker->address(),
            'phone' => $this->faker->unique()->phoneNumber(),
            'email' => $email,
            'username' => $email,
            'loginBy' => 'email',
            'password' => Hash::make($this->faker->password(8)), // password
            'is_active' => 1,
        ];
    }
}
