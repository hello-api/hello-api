<?php

namespace App\Containers\AppSection\Authentication\Actions;

use App\Containers\AppSection\Authentication\Tasks\SendVerificationEmailTask;
use App\Containers\AppSection\Authentication\UI\API\Requests\SendVerificationEmailRequest;
use App\Ship\Parents\Actions\Action as ParentAction;

// TODO
class SendVerificationEmailAction extends ParentAction
{
    public function __construct(
        private readonly SendVerificationEmailTask $sendVerificationEmailTask,
    ) {
    }

    public function run(SendVerificationEmailRequest $request): void
    {
        $this->sendVerificationEmailTask->run($request->user(), $request->verification_url);
    }
}
