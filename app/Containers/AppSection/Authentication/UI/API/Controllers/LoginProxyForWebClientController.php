<?php

namespace App\Containers\AppSection\Authentication\UI\API\Controllers;

use App\Containers\AppSection\Authentication\Actions\ApiLoginProxyForWebClientAction;
use App\Containers\AppSection\Authentication\UI\API\Documentation\Parameters\LoginProxyForWebClientParams;
use App\Containers\AppSection\Authentication\UI\API\Documentation\Responses\LoginProxyForWebClientResponse;
use App\Containers\AppSection\Authentication\UI\API\Requests\LoginProxyPasswordGrantRequest;
use App\Containers\AppSection\Authentication\UI\API\Transformers\TokenTransformer;
use App\Ship\Parents\Controllers\ApiController;
use Illuminate\Http\JsonResponse;
use MohammadAlavi\LaravelOpenApi\Attributes\Collection;
use MohammadAlavi\LaravelOpenApi\Attributes\Operation;
use MohammadAlavi\LaravelOpenApi\Attributes\Parameters;
use MohammadAlavi\LaravelOpenApi\Attributes\PathItem;
use MohammadAlavi\LaravelOpenApi\Attributes\Response;

#[PathItem]
class LoginProxyForWebClientController extends ApiController
{
    /**
     * Login.
     */
    #[Operation(tags: ['user'], deprecated: true)]
    #[Response(factory: LoginProxyForWebClientResponse::class)]
    #[Collection(['private', 'public'])]
    #[Parameters(factory: LoginProxyForWebClientParams::class)]
    public function __invoke(LoginProxyPasswordGrantRequest $request, ApiLoginProxyForWebClientAction $action): JsonResponse
    {
        $result = $action->run($request);

        return $this->json($this->transform($result->token, TokenTransformer::class))->withCookie($result->refreshTokenCookie);
    }
}
