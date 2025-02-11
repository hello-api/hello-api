<?php

namespace App\Containers\AppSection\Authorization\Data\Factories;

use App\Containers\AppSection\Authorization\Enums\Role as RoleEnum;
use App\Containers\AppSection\Authorization\Models\Role;
use App\Ship\Parents\Factories\Factory as ParentFactory;

/**
 * @template TModel of Role
 *
 * @extends ParentFactory<TModel>
 */
class RoleFactory extends ParentFactory
{
    /** @var class-string<TModel> */
    protected $model = Role::class;

    public function definition(): array
    {
        return [
            'name' => fake()->unique()->firstName(),
            'guard_name' => 'api',
        ];
    }

    public function admin(): static
    {
        return $this->state(fn () => ['name' => RoleEnum::SUPER_ADMIN->value]);
    }

    public function withGuard(string $guard): static
    {
        return $this->state(fn () => ['guard_name' => $guard]);
    }
}
