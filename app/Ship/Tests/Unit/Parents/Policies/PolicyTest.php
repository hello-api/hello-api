<?php

namespace App\Ship\Tests\Unit\Parents\Policies;

use App\Containers\AppSection\User\Models\User;
use App\Ship\Parents\Policies\Policy;
use App\Ship\Parents\Providers\ServiceProvider;
use App\Ship\Parents\Requests\Request;
use App\Ship\Tests\ShipTestCase;
use Illuminate\Contracts\Auth\Access\Gate;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(Policy::class)]
final class PolicyTest extends ShipTestCase
{
    public function testAdminCanBypassAllAuthorizations(): void
    {
        $this->getTestingUser(createUserAsAdmin: true);

        $request = FakeRequest::injectData([], $this->testingUser);

        $this->assertTrue($request->authorize(app(Gate::class)));
    }

    public function testNonAdminCannotBypassAllAuthorizations(): void
    {
        $this->getTestingUser();

        $request = FakeRequest::injectData([], $this->testingUser);

        $this->assertFalse($request->authorize(app(Gate::class)));
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->app->register(FakeServiceProvider::class);
    }
}

class FakeUserPolicy extends Policy
{
    public function access(User $user): bool
    {
        return false;
    }
}

class FakeRequest extends Request
{
    public function authorize(Gate $gate): bool
    {
        return $gate->allows('access', FakeUser::class);
    }
}

class FakeUser extends User
{
}

class FakeServiceProvider extends ServiceProvider
{
    protected array $policies = [
        FakeUser::class => FakeUserPolicy::class,
    ];
}
