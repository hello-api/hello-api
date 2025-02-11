<?php

namespace App\Containers\AppSection\Authentication\Tests\Functional\WEB;

use App\Containers\AppSection\Authentication\Tests\Functional\WebTestCase;
use App\Containers\AppSection\Authentication\UI\WEB\Controllers\HomePageController;
use App\Containers\AppSection\User\Models\User;
use PHPUnit\Framework\Attributes\CoversNothing;

#[CoversNothing]
final class LogoutTest extends WebTestCase
{
    public function testLogout(): void
    {
        $this->actingAs(User::factory()->createOne(), 'web');
        $this->assertAuthenticated('web');

        $response = $this->post('logout');

        $response->assertRedirect(action(HomePageController::class));
        $this->assertGuest('web');
    }

    public function testLogoutWhileUnauthenticated(): void
    {
        $response = $this->post('logout');

        $response->assertRedirect(action(HomePageController::class));
    }
}
