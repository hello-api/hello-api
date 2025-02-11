<?php

namespace App\Containers\AppSection\Authentication\Actions;

use App\Containers\AppSection\Authentication\Classes\LoginFieldParser;
use App\Containers\AppSection\Authentication\DataTransferObjects\AuthResult;
use App\Containers\AppSection\Authentication\Exceptions\LoginFailed;
use App\Containers\AppSection\Authentication\Tasks\CallOAuthServerTask;
use App\Containers\AppSection\Authentication\Tasks\MakeRefreshTokenCookieTask;
use App\Containers\AppSection\Authentication\UI\API\Requests\LoginProxyPasswordGrantRequest;
use App\Ship\Parents\Actions\Action as ParentAction;

class ApiLoginProxyForWebClientAction extends ParentAction
{
    public function __construct(
        private readonly CallOAuthServerTask $callOAuthServerTask,
        private readonly MakeRefreshTokenCookieTask $makeRefreshTokenCookieTask,
    ) {
    }

    /**
     * @throws LoginFailed
     * @throws \Exception
     */
    public function run(LoginProxyPasswordGrantRequest $request): AuthResult
    {
        $sanitizedData = $request->sanitize([
            ...array_keys(config('appSection-authentication.login.fields')),
            'password',
            'client_id' => config('appSection-authentication.clients.web.id'),
            'client_secret' => config('appSection-authentication.clients.web.secret'),
            'grant_type' => 'password',
            'scope' => '',
        ]);

        $loginFields = LoginFieldParser::extractAll($sanitizedData);

        $exception = null;
        foreach ($loginFields as $loginField) {
            $sanitizedData['username'] = $loginField->value;

            try {
                $token = $this->callOAuthServerTask->run($sanitizedData, $request->headers->get('accept-language'));
                $refreshTokenCookie = $this->makeRefreshTokenCookieTask->run($token->refreshToken);

                return new AuthResult($token, $refreshTokenCookie);
            } catch (LoginFailed $e) {
                $exception = $e;
                // try the next login field
            }
        }

        throw $exception;
    }
}
