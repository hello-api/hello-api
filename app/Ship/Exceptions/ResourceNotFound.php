<?php

namespace App\Ship\Exceptions;

use App\Ship\Parents\Exceptions\HttpException as ParentHttpException;
use Symfony\Component\HttpFoundation\Response;

class ResourceNotFound extends ParentHttpException
{
    public static function create(string $resourceName = 'Resource'): static
    {
        return new static(Response::HTTP_NOT_FOUND, "{$resourceName} not found.");
    }
}
