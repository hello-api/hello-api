<?php

namespace App\Ship\Documentation\Collections;

class PrivateCollection implements \Stringable
{
    public function __toString(): string
    {
        return 'private';
    }
}
