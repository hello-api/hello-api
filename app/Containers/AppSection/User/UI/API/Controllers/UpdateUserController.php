<?php

namespace App\Containers\AppSection\User\UI\API\Controllers;

use App\Containers\AppSection\User\Actions\UpdateUserAction;
use App\Containers\AppSection\User\UI\API\Documentation\Parameters\UpdateUser;
use App\Containers\AppSection\User\UI\API\Documentation\Responses\UserTransformerResponse;
use App\Containers\AppSection\User\UI\API\Documentation\SecuritySchemes\BearerTokenSecurityScheme;
use App\Containers\AppSection\User\UI\API\Requests\UpdateUserRequest;
use App\Containers\AppSection\User\UI\API\Transformers\UserTransformer;
use App\Ship\Parents\Controllers\ApiController;
use Vyuldashev\LaravelOpenApi\Attributes\Collection;
use Vyuldashev\LaravelOpenApi\Attributes\Operation;
use Vyuldashev\LaravelOpenApi\Attributes\Parameters;
use Vyuldashev\LaravelOpenApi\Attributes\PathItem;
use Vyuldashev\LaravelOpenApi\Attributes\Response;

#[PathItem]
class UpdateUserController extends ApiController
{
    /**
     * Update users
     *
     * Description for body
     */
    #[Operation(security: BearerTokenSecurityScheme::class)]
    #[Parameters(factory: UpdateUser::class)]
    #[Response(factory: UserTransformerResponse::class)]
    #[Collection(['private'])]
    public function __invoke(UpdateUserRequest $request, UpdateUserAction $action): array
    {
        $request->mapInput([
            'new_password' => 'password',
        ]);
        $user = $action->run($request);

        return $this->transform($user, UserTransformer::class);
    }
}
