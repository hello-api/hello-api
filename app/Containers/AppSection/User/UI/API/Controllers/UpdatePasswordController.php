<?php

namespace App\Containers\AppSection\User\UI\API\Controllers;

use App\Containers\AppSection\User\Actions\UpdatePasswordAction;
use App\Containers\AppSection\User\UI\API\Requests\UpdatePasswordRequest;
use App\Containers\AppSection\User\UI\API\Transformers\UserTransformer;
use App\Ship\Parents\Controllers\ApiController;

class UpdatePasswordController extends ApiController
{
    public function __invoke(UpdatePasswordRequest $request, UpdatePasswordAction $action): array
    {
        $user = $action->run($request->user_id, $request->new_password);

        return $this->transform($user, UserTransformer::class);
    }
}
