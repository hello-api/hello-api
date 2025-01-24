<?php

namespace App\Containers\AppSection\User\Tests\Unit\Providers;

use App\Containers\AppSection\User\Providers\UserServiceProvider;
use App\Containers\AppSection\User\Tests\UnitTestCase;
use Illuminate\Validation\Rules\Password;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(UserServiceProvider::class)]
final class UserServiceProviderTest extends UnitTestCase
{
    public function testProviderSetsDefaultPasswordRules(): void
    {
        $this->assertEquals(
            Password::min(8)
                ->letters()
                ->mixedCase()
                ->numbers()
                ->symbols(),
            Password::defaults(),
        );
    }
}
