<?php

namespace App\Exceptions;

use DragonCode\ApiResponse\Exceptions\Laravel\Eight\ApiHandler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];
}
