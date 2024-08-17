<?php

namespace Hellm\ToxicMvc\core\Router\Exception;

use Exception;

class RouterException
{
    private string $message;
    private int $code;

    public function __construct(string $message, int $code)
    {
        throw new Exception($message, $code);

        // $logger = new Logger();
        // $logger->message = $message;
        // $logger->created_at = date("Y-m-d", time());
        // $logger->save();
    }
}
