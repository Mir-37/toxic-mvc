<?php

class ConsoleException extends Exception
{

    protected $message;
    protected $code;

    public function __construct($message, $code)
    {
        $this->message = $code;

        // TODO: Implement logger
    }
}
