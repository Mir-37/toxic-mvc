<?php

namespace Hellm\ToxicMvc\routes;

use Hellm\ToxicMvc\core\Router\Router;
use Hellm\ToxicMvc\http\controller\TestController;

$route = new Router();

$route->add("GET", "/test/{id}", [TestController::class, "index"]);
$route->add("GET", "/test/{slug}/edit", [TestController::class, "index"], "[a-zA-Z0-9-]+");
$route->add("GET", "/test", [TestController::class, "index"]);

$route->dispatch();
