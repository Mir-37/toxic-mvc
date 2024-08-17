<?php

namespace Hellm\ToxicMvc\core\Router;

use Hellm\ToxicMvc\core\Router\Exception\RouterException;
use Hellm\ToxicMvc\core\Router\Interface\RouterInterface;
use Hellm\ToxicMvc\core\Router\Trait\RouterHelperTrait;

class Router implements RouterInterface
{
    use RouterHelperTrait;

    private array $routes = [];
    private string $url_path;
    private string $base_url;

    public function __construct()
    {
        $this->base_url = "http://localhost:8080/";
        $this->url_path = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
    }

    public function add(string $http_method, string $url_path, array $controller, string $regex = "\d+"): void
    {
        $path = $this->normalizePath($url_path);
        $this->routes[] = [
            'path' => $path,
            'method' => strtoupper($http_method),
            'controller' => $controller,
            "regex" => $regex,
            'dispatched' => false
        ];
    }


    public function dispatch(): void
    {
        $path = $this->normalizePath($this->url_path);

        $method = strtoupper($_SERVER["REQUEST_METHOD"]);

        foreach ($this->routes as $route) {

            $pattern = preg_replace('#\{(\w+)\}#', '(?<$1>' . $route["regex"] . ')', $route['path']);
            $pattern = "#^{$pattern}/?$#";

            if (!preg_match($pattern, $path,  $match) || $route['method'] != $method) {
                continue;
            }

            list($class_name, $function_name) = $route["controller"];

            $params = array_filter($match, 'is_string', ARRAY_FILTER_USE_KEY);

            try {
                $controller_instance = new $class_name;
                $controller_instance->$function_name(...array_values($params));
                $route["dispatched"] = true;
                return;
            } catch (\Throwable $th) {
                throw new RouterException($th->getMessage(), 500);
                return;
            }
        }
        throw new RouterException("Page not found", 404);
    }


    /**
     * Get all the routes in the router
     *
     * @return array
     */
    public function getRoutes(): array
    {
        return $this->routes;
    }
}
