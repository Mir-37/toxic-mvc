<?php

namespace Hellm\ToxicMvc\core\Router\Exception;

use Exception;

class RouterException extends Exception
{
    protected $message;
    protected $code;

    public function __construct(string $message, int $code)
    {
        $this->message = $message;
        $this->code = $code;
        // $logger = new Logger();
        // $logger->message = $message;
        // $logger->created_at = date("Y-m-d", time());
        // $logger->save();
    }
}
