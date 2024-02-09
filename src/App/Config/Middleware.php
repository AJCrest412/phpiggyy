<?php

declare(strict_types=1);

namespace App\Config;

use App\Middleware\CsrfGuardMiddleware;
use App\Middleware\CsrfTokenMiddleware;
use App\Middleware\FlashMiddleware;
use App\Middleware\SessionMiddleware;
use App\Middleware\TemplateDataMiddleware;
use App\Middleware\ValidationExceptionMIddleware;
use Framework\App;

function registerMiddleware(App $app)
{
  $app->addMiddleware(CsrfGuardMiddleware::class);
  $app->addMiddleware(CsrfTokenMiddleware::class);
  $app->addMiddleware(TemplateDataMiddleware::class);
  $app->addMiddleware(ValidationExceptionMIddleware::class);
  $app->addMiddleware(FlashMiddleware::class);
  $app->addMiddleware(SessionMiddleware::class);
}
