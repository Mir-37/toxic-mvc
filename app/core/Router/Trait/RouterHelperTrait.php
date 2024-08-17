<?php

namespace Hellm\ToxicMvc\core\Router\Trait;

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
}
