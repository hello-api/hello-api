<?php

namespace App\Containers\AppSection\Authorization\Enums;

enum Role: string
{
    case SUPER_ADMIN = 'admin';

    public function label(): string
    {
        return match ($this) {
            self::SUPER_ADMIN => 'Super Admin',
        };
    }
}
