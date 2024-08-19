<?php

namespace Hellm\ToxicMvc\Router\Trait;

use Closure;
use Hellm\ToxicMvc\Constants\RegEx;

trait RouterHelperTrait
{
    private function normalizePath(string $url_path): string
    {
        $this->formatQueryString($url_path);

        $url_path = str_replace($this->base_url, "", $url_path);

        $url_path = trim($url_path, "/");
        $url_path = "/{$url_path}/";
        $url_path = preg_replace("#[/]{2,}#", '/', $url_path);

        return $url_path;
    }

    protected function formatQueryString(string $url): string
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

    public function get(string $path, string|array|Closure $callback, string $regex = RegEx::INT): void
    {
        $this->add('GET', $path, $callback, $regex);
    }

    public function post(string $path, string|array|Closure $callback, string $regex = RegEx::INT): void
    {
        $this->add('POST', $path, $callback, $regex);
    }

    public function put(string $path, string|array|Closure $callback, string $regex = RegEx::INT): void
    {
        $this->add('PUT', $path, $callback, $regex);
    }

    public function delete(string $path, string|array|Closure $callback, string $regex = RegEx::INT): void
    {
        $this->add('DELETE', $path, $callback, $regex);
    }
}
