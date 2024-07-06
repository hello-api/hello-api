<?php

namespace App\Ship\Documentation\Collections;

use Stringable;

class PrivateCollection implements Stringable
{
    public function __toString(): string
    {
        return 'private';
    }
}
