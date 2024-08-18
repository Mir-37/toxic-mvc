<?php

namespace Hellm\ToxicMvc\core\Http;

class Request
{
    public string $method;
    public string $uri;
    public array $query_params;
    public array $post_data;
    public array $headers;

    public function __construct()
    {
        $this->method = $_SERVER["REQUEST_METHOD"];
        $this->uri = $_SERVER['REQUEST_URI'];
        $this->query_params = $_GET;
        $this->post_data = $_POST;
        $this->headers = getallheaders();
    }

    public function method(): string
    {
        return $this->method;
    }

    public function uri(): string
    {
        return $this->uri;
    }

    public function query($key = null): array|string
    {
        if ($key) {
            return $this->query_params[$key] ?? null;
        }
        return $this->query_params;
    }

    public function input($key = null): array|string
    {
        if ($key) {
            return $this->post_data[$key] ?? null;
        }
        return $this->post_data;
    }

    public function header($key = null): array|string
    {
        if ($key) {
            return $this->headers[$key] ?? null;
        }
        return $this->headers;
    }
}
