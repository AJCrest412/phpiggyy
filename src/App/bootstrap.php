<?php

declare(strict_types=1);

require __DIR__ . "/../../vendor/autoload.php";

use Framework\App;

use function App\Config\registerMiddleware;
use function App\Config\registerRoutes;
use App\Config\Paths;
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(Paths::ROOT);
$dotenv->load();

$app = new App(Paths::SOURCE . "App/container-definations.php");
registerRoutes($app);
registerMiddleware($app);

return $app;
