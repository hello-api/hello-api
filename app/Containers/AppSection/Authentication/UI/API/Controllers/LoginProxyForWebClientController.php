<?php

namespace App\Containers\AppSection\Authentication\UI\API\Controllers;

use App\Containers\AppSection\Authentication\Actions\ApiLoginProxyForWebClientAction;
use App\Containers\AppSection\Authentication\UI\API\Documentation\Parameters\LoginProxyForWebClient;
use App\Containers\AppSection\Authentication\UI\API\Requests\LoginProxyPasswordGrantRequest;
use App\Containers\AppSection\Authentication\UI\API\Transformers\TokenTransformer;
use App\Containers\AppSection\User\UI\API\Documentation\Responses\UserTransformerResponse;
use App\Ship\Parents\Controllers\ApiController;
use Illuminate\Http\JsonResponse;
use Vyuldashev\LaravelOpenApi\Attributes\Collection;
use Vyuldashev\LaravelOpenApi\Attributes\Operation;
use Vyuldashev\LaravelOpenApi\Attributes\Parameters;
use Vyuldashev\LaravelOpenApi\Attributes\PathItem;
use Vyuldashev\LaravelOpenApi\Attributes\Response;

#[PathItem]
class LoginProxyForWebClientController extends ApiController
{
    /**
     * Login
     */
    #[Operation(tags: ['user'], deprecated: true)]
    #[Response(factory: UserTransformerResponse::class)]
    #[Collection(['private', 'public'])]
    #[Parameters(factory: LoginProxyForWebClient::class)]
    public function __invoke(LoginProxyPasswordGrantRequest $request, ApiLoginProxyForWebClientAction $action): JsonResponse
    {
        $result = $action->run($request);

        return $this->json($this->transform($result->token, TokenTransformer::class))->withCookie($result->refreshTokenCookie);
    }
}
