<?php

namespace App\Containers\AppSection\Authentication\Exceptions;

use App\Ship\Parents\Exceptions\HttpException as ParentHttpException;
use Symfony\Component\HttpFoundation\Response;

class LoginFailed extends ParentHttpException
{
    public static function create(): static
    {
        return new static(Response::HTTP_UNPROCESSABLE_ENTITY, 'Login Failed.');
    }
}
