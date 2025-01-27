<?php

namespace App\Containers\AppSection\Authentication\Tests\Unit\Actions;

use App\Containers\AppSection\Authentication\Actions\SendVerificationEmailAction;
use App\Containers\AppSection\Authentication\Tasks\SendVerificationEmailTask;
use App\Containers\AppSection\Authentication\Tests\UnitTestCase;
use App\Containers\AppSection\Authentication\UI\API\Requests\SendVerificationEmailRequest;
use App\Containers\AppSection\User\Models\User;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(SendVerificationEmailAction::class)]
class SendVerificationEmailActionTest extends UnitTestCase
{
    public function testCanSendVerificationEmail(): void
    {
        $taskSpy = $this->mock(SendVerificationEmailTask::class);
        $action = app(SendVerificationEmailAction::class);
        $request = SendVerificationEmailRequest::injectData([
            'verification_url' => 'http://localhost',
        ], User::factory()->createOne());
        $taskSpy->expects()->run($request->user(), $request->verification_url);

        $action->run($request);
    }
}
