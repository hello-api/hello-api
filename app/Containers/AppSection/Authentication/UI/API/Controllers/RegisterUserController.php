<?php

namespace App\Containers\AppSection\Authentication\UI\API\Controllers;

use App\Containers\AppSection\Authentication\Actions\RegisterUserAction;
use App\Containers\AppSection\Authentication\UI\API\Documentation\Parameters\RegisterUserParams;
use App\Containers\AppSection\Authentication\UI\API\Documentation\Responses\RegisterUserResponse;
use App\Containers\AppSection\Authentication\UI\API\Documentation\SecuritySchemes\BearerTokenSecurityScheme;
use App\Containers\AppSection\Authentication\UI\API\Requests\RegisterUserRequest;
use App\Containers\AppSection\User\UI\API\Transformers\UserTransformer;
use App\Ship\Parents\Controllers\ApiController;
use MohammadAlavi\LaravelOpenApi\Attributes\Operation;
use MohammadAlavi\LaravelOpenApi\Attributes\Parameters;
use MohammadAlavi\LaravelOpenApi\Attributes\PathItem;
use MohammadAlavi\LaravelOpenApi\Attributes\Response;

#[PathItem]
class RegisterUserController extends ApiController
{
    #[Operation(security: BearerTokenSecurityScheme::class)]
    #[Parameters(factory: RegisterUserParams::class)]
    #[Response(factory: RegisterUserResponse::class)]
    public function __invoke(RegisterUserRequest $request, RegisterUserAction $action): array
    {
        $user = $action->transactionalRun($request);

        return $this->transform($user, UserTransformer::class);
    }
}
