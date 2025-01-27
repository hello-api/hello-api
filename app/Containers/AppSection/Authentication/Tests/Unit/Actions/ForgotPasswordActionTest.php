<?php

namespace App\Containers\AppSection\Authentication\Tests\Unit\Actions;

use App\Containers\AppSection\Authentication\Actions\ForgotPasswordAction;
use App\Containers\AppSection\Authentication\Mails\ForgotPassword;
use App\Containers\AppSection\Authentication\Tests\UnitTestCase;
use App\Containers\AppSection\Authentication\UI\API\Requests\ForgotPasswordRequest;
use Illuminate\Support\Facades\Mail;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(ForgotPasswordAction::class)]
final class ForgotPasswordActionTest extends UnitTestCase
{
    public function testIfUserExistsShouldReturnTrue(): void
    {
        Mail::fake();
        $user = $this->getTestingUser();
        $data = [
            'email' => $user->email,
            'reseturl' => 'http://localhost',
        ];

        $request = new ForgotPasswordRequest($data);
        $result = app(ForgotPasswordAction::class)->run($request);

        $this->assertTrue($result);
        Mail::assertQueued(ForgotPassword::class);
    }

    public function testAlwaysReturnsTrue(): void
    {
        Mail::fake();
        $data = [
            'email' => 'ganldalf@the.grey',
        ];

        $request = new ForgotPasswordRequest($data);
        $result = app(ForgotPasswordAction::class)->run($request);

        $this->assertTrue($result);
        Mail::assertNotQueued(ForgotPassword::class);
    }
}
