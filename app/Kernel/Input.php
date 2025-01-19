<?php

namespace App\Kernel;

class Input
{
    public function toArray(): array
    {
        return get_object_vars($this);
    }
}