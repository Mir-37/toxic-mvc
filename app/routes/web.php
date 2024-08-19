<?php

namespace Hellm\ToxicMvc\routes;

use Hellm\ToxicMvc\Http\Request;
use Hellm\ToxicMvc\Http\Response;
use Hellm\ToxicMvc\Router\Router;
use App\http\controller\TestController;
use Hellm\ToxicMvc\Router\Facade\Route;

$request = new Request();
$reponse = new Response();
$route = new Route(new Router($request, $reponse));

Route::get("GET", "/test/{id}", [TestController::class, "index"]);
Route::get("GET", "/test/{slug}/edit", [TestController::class, "index"], "[a-zA-Z0-9-]+");
Route::get("GET", "/test", [TestController::class, "index"]);

Route::dispatch();
