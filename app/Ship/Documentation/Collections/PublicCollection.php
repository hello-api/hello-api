<?php

namespace App\Ship\Documentation\Collections;

use Stringable;

class PublicCollection implements Stringable
{
    public function __toString(): string
    {
        return 'public';
    }
}
