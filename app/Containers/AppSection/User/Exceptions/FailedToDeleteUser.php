<?php

namespace App\Containers\AppSection\User\Exceptions;

use App\Ship\Parents\Exceptions\HttpException;
use Symfony\Component\HttpFoundation\Response;

class FailedToDeleteUser extends HttpException
{
    public static function becauseCannotDeleteItself(): self
    {
        return new self(Response::HTTP_UNPROCESSABLE_ENTITY, 'You cannot delete yourself.');
    }
}
