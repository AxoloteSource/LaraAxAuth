<?php

namespace App\Core\Enums;

enum Http: int
{
    case Unauthenticated = 401;
    case Forbidden = 403;
    case NotFound = 404;
    case UnprocessableEntity = 422;
    case Success = 200;
    case PartialContent = 206;
    case Created = 201;
    case NoContent = 204;
    case ServerError = 500;
}
