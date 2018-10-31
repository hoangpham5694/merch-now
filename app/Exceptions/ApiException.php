<?php

namespace App\Exceptions;

use Exception;

class ApiException extends Exception
{
    protected $statusCode;

    public function __construct(string $message = "", int $code = 0, Throwable $previous = null)
    {
        $this->statusCode = $code;
        parent::__construct($message, $code, $previous);
    }

    /**
     * Get the HTTP Status Code of the RestException
     * @return int HTTP Status Code
     */
    public function getStatusCode() {
        return $this->statusCode;
    }
}
