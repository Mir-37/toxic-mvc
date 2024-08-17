<?php

namespace Hellm\ToxicMvc\routes;

use Hellm\ToxicMvc\Base\Router\BaseRouter;
use Hellm\ToxicMvc\http\controller\TestController;

$route = new BaseRouter();


$route->add("GET", "/test/{id}", [TestController::class, "index"]);
$route->add("GET", "/test/{id}/edit", [TestController::class, "index"]);
$route->add("GET", "/test", [TestController::class, "index"]);

$route->dispatch();
