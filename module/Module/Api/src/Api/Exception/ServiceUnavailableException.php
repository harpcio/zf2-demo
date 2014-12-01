<?php

namespace Module\Api\Exception;

use Zend\Http\Response;

class ServiceUnavailableException extends AbstractException
{
    public function __construct(
        $message = "Service Unavailable",
        $code = Response::STATUS_CODE_503,
        \Exception $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}