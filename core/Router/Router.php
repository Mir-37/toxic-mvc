<?php

namespace Hellm\ToxicMvc\Router;

use Closure;
use Hellm\ToxicMvc\Http\Request;
use Hellm\ToxicMvc\Http\Response;
use Hellm\ToxicMvc\Constants\RegEx;
use Hellm\ToxicMvc\Router\Trait\RouterHelperTrait;
use Hellm\ToxicMvc\Router\Interface\RouterInterface;

use Hellm\ToxicMvc\core\Router\Exception\RouterException;

class Router implements RouterInterface
{
    use RouterHelperTrait;

    private array $routes = [];
    private string $url_path;
    private Request $request;
    private Response $response;
    private string $base_url;

    public function __construct(Request $request, Response $response)
    {
        $this->request = $request;
        $this->response = $response;
        $this->base_url = "http://localhost:8080/";
        $this->url_path = parse_url($this->request->uri(), PHP_URL_PATH);
    }

    public function add(string $http_method, string $url_path, array|string|Closure $callback, string $regex = RegEx::INT): void
    {
        $path = $this->normalizePath($url_path);
        $this->routes[strtoupper($http_method)][$path] = [
            'callback' => $callback,
            'regex' => $regex
        ];
    }

    public function dispatch(): void
    {
        $path = $this->normalizePath($this->url_path);
        $method = strtoupper($this->request->method());

        if (!isset($this->routes[$method])) {
            throw new RouterException("Method not allowed", 405);
        }

        foreach ($this->routes[$method] as $routePath => $route) {
            $pattern = preg_replace('#\{(\w+)\}#', '(?<$1>' . $route["regex"] . ')', $routePath);
            $pattern = "#^{$pattern}/?$#";
            $route_dispatched = isset($route["dispatched"]) && !$route["dispatched"] ? true : false;
            if (
                !preg_match($pattern, $path,  $match) &&
                !$route_dispatched
            ) {
                continue;
            }

            $this->resolve($route['callback'], $match);
            return;
        }

        throw new RouterException("Page not found", 404);
    }

    public function resolve(array|string|Closure $callback, array $params = []): mixed
    {
        if (is_string($callback)) {
            // return $this->renderView($callback);
        }

        if (is_array($callback)) {
            try {
                [$class_name, $function_name] = $callback;
                $controller_instance = new $class_name();
                return $controller_instance->$function_name($this->request, ...array_values($params));
            } catch (\Throwable $th) {
                throw new RouterException($th->getMessage(), 500);
            }
        }

        if ($callback instanceof Closure) {
            try {
                return call_user_func($callback, $this->request, $this->response);
            } catch (\Throwable $th) {
                throw new RouterException($th->getMessage(), 500);
            }
        }
    }


    public function getRoutes(): array
    {
        return $this->routes;
    }
}
