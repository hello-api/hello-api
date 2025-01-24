<?php

namespace App\Containers\AppSection\Authentication\Tests\Unit\Mails;

use App\Containers\AppSection\Authentication\Mails\ForgotPassword;
use App\Containers\AppSection\Authentication\Tests\UnitTestCase;
use App\Containers\AppSection\User\Models\User;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(ForgotPassword::class)]
final class ForgotPasswordTest extends UnitTestCase
{
    public function testRenderMail(): void
    {
        $user = User::factory()->createOne();
        $token = 'token-b510d059-5d0d-4618-9eb9-b315b4a07f12';
        $resetUrl = 'https://refresh-your-pass.world';

        $mail = new ForgotPassword($user, $token, $resetUrl);
        $view = $mail->build();

        $view->assertHasTo($user->email, $user->name);
        $view->assertSeeInHtml($token);
        $view->assertSeeInHtml(config('app.url'));
        $view->assertSeeInHtml($user->email);
    }
}
