<?php

namespace App\Ship\Documentation\Collections;

class PublicCollection implements \Stringable
{
    public function __toString(): string
    {
        return 'public';
    }
}
