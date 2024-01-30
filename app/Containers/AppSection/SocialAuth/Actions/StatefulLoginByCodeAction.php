<?php

namespace App\Containers\AppSection\SocialAuth\Actions;

use Apiato\Core\Abstracts\Actions\Action;
use App\Containers\AppSection\SocialAuth\Exceptions\OAuthIdentityNotFoundException;
use App\Containers\AppSection\SocialAuth\Tasks\StatefulGetOAuthUserFromCodeTask;
use App\Containers\AppSection\SocialAuth\Values\SocialAuthOutcome;
use Prettus\Validator\Exceptions\ValidatorException;

final class StatefulLoginByCodeAction extends Action
{
    public function __construct(
        private readonly StatefulGetOAuthUserFromCodeTask $statefulGetOAuthUserFromCodeTask,
        private readonly LoginSubAction $loginSubAction,
    ) {
    }

    /**
     * @throws OAuthIdentityNotFoundException
     * @throws ValidatorException
     * @throws \JsonException
     */
    public function run(string $provider): SocialAuthOutcome
    {
        $oAuthUser = $this->statefulGetOAuthUserFromCodeTask->run($provider);

        return $this->loginSubAction->run($provider, $oAuthUser);
    }
}