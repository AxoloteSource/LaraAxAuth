<?php

namespace App\Enums;

enum HttpErrors: int
{
    case BadRequest = 400;
    case Success = 200;
}
