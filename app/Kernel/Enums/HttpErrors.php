<?php

namespace App\Kernel\Enums;

enum HttpErrors: int {
    case BadRequest = 400;
    case Unauthenticated = 401;
    case Forbidden = 403;
    case NotFound = 404;
    case Success = 200;
    case PartialContent = 206;
}