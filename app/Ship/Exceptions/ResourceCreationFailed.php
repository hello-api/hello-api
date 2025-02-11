<?php

namespace App\Ship\Exceptions;

use App\Ship\Parents\Exceptions\HttpException as ParentHttpException;
use Symfony\Component\HttpFoundation\Response;

final class ResourceCreationFailed extends ParentHttpException
{
    public static function create(string $resourceName = 'Resource'): self
    {
        return new self(Response::HTTP_EXPECTATION_FAILED, "{$resourceName} creation failed.");
    }
}
