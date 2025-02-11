<?php

namespace App\Ship\Exceptions;

use App\Ship\Parents\Exceptions\HttpException as ParentHttpException;
use Symfony\Component\HttpFoundation\Response;

final class ResourceNotFound extends ParentHttpException
{
    public static function create(string $resourceName = 'Resource'): self
    {
        return new self(Response::HTTP_NOT_FOUND, "{$resourceName} not found.");
    }
}
