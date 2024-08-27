<?php

namespace App\Containers\AppSection\User\UI\API\Controllers;

use App\Containers\AppSection\User\Actions\UpdateUserAction;
use App\Containers\AppSection\User\UI\API\Documentation\Parameters\UpdateUserParams;
use App\Containers\AppSection\User\UI\API\Documentation\Responses\UpdateUserResponse;
use App\Containers\AppSection\Authentication\UI\API\Documentation\SecuritySchemes\BearerTokenSecurityScheme;
use App\Containers\AppSection\User\UI\API\Requests\UpdateUserRequest;
use App\Containers\AppSection\User\UI\API\Transformers\UserTransformer;
use App\Ship\Parents\Controllers\ApiController;
use MohammadAlavi\LaravelOpenApi\Attributes\Collection;
use MohammadAlavi\LaravelOpenApi\Attributes\Operation;
use MohammadAlavi\LaravelOpenApi\Attributes\Parameters;
use MohammadAlavi\LaravelOpenApi\Attributes\PathItem;
use MohammadAlavi\LaravelOpenApi\Attributes\Response;

#[PathItem]
class UpdateUserController extends ApiController
{
    /**
     * Update users
     *
     * Description for body
     */
    #[Operation(security: BearerTokenSecurityScheme::class)]
    #[Parameters(factory: UpdateUserParams::class)]
    #[Response(factory: UpdateUserResponse::class)]
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
