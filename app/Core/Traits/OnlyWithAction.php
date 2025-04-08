<?php

namespace App\Core\Traits;

trait OnlyWithAction
{
    protected function before(): bool
    {
        return true;
    }

    protected function after(): bool
    {
        return true;
    }
}
