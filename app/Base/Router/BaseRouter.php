<?php

namespace Hellm\ToxicMvc\Base\Router;

class BaseRouter
{
    private array $routes = [];
    private string $url_path;
    private string $base_url;

    public function __construct()
    {
        $this->base_url = "http://localhost:8080/";
        $this->url_path = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
    }

    public function add(string $http_method, string $url_path, array $controller): void
    {
        $path = $this->normalizePath($url_path);
        $this->routes[] = [
            'path' => $path,
            'method' => strtoupper($http_method),
            'controller' => $controller,
            'dispatched' => false
        ];
    }

    public function dispatch(): void
    {
        $path = $this->normalizePath($this->url_path);

        $method = strtoupper($_SERVER["REQUEST_METHOD"]);
        foreach ($this->routes as $route) {

            $pattern = preg_replace('#\{(\w+)\}#', '(?<$1>[^/]+)', $route['path']);
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
                throw $th;
                $this->returnBadRequest($th->getMessage(), 500);
                return;
            }
        }
        $this->returnBadRequest("Not Found", 404);
    }

    private function normalizePath(string $url_path): string
    {
        $this->formatQueryString($url_path);

        $url_path = str_replace($this->base_url, "", $url_path);

        $url_path = trim($url_path, "/");
        $url_path = "/{$url_path}/";
        $url_path = preg_replace("#[/]{2,}#", '/', $url_path);

        return $url_path;
    }

    protected function formatQueryString($url)
    {
        if ($url != '') {
            $parts = explode('&', $url, 2);

            if (strpos($parts[0], '=') === false) {
                $url = $parts[0];
            } else {
                $url = '';
            }
        }

        return rtrim($url, '/');
    }

    private function returnBadRequest(string $message, int $code): void
    {
        http_response_code($code);
        // $logger = new Logger();
        // $logger->message = $message;
        // $logger->created_at = date("Y-m-d", time());
        // $logger->save();
    }
}
