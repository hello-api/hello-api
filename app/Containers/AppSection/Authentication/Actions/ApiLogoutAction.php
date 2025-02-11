<?php

namespace App\Containers\AppSection\Authentication\Actions;

use App\Containers\AppSection\Authentication\UI\API\Requests\LogoutRequest;
use App\Ship\Parents\Actions\Action as ParentAction;

class ApiLogoutAction extends ParentAction
{
    public function run(LogoutRequest $request): void
    {
        $request->user()?->token()?->revoke();
    }
}
