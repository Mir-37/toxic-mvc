<?php

namespace Hellm\ToxicMvc\Router\Facade;

use Closure;
use Hellm\ToxicMvc\Router\Router;
use Hellm\ToxicMvc\Router\Trait\RouterHelperTrait;

class Route
{
    use RouterHelperTrait;

    protected static Router $router;

    public function __construct(Router $router)
    {
        self::$router = $router;
    }

    public static function get(string $path, string|array|Closure $callback): void
    {
        self::$router->get($path, $callback);
    }

    public static function post(string $path, string|array|Closure $callback): void
    {
        self::$router->post($path, $callback);
    }

    public static function put(string $path, string|array|Closure $callback): void
    {
        self::$router->put($path, $callback);
    }

    public static function delete(string $path, string|array|Closure $callback): void
    {
        self::$router->delete($path, $callback);
    }

    public static function dispatch(): void
    {
        self::$router->dispatch();
    }
}
