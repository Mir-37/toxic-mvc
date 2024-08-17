<?php

namespace Hellm\ToxicMvc\core\Router\Interface;

interface RouterInterface
{
    /**
     * Add a route to the router
     * @param string $http_method
     * @param string $url_path
     * @param array $controller
     * @param string $regex
     * 
     * @return void
     */
    public function add(string $http_method, string $url_path, array $controller, string $regex = "\d+"): void;

    /**
     * Dispatch the routes in the router
     * 
     * @return void
     */
    public function dispatch(): void;
}
