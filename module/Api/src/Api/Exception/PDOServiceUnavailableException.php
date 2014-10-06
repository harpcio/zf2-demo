<?php

namespace Api\Exception;

use Zend\Http\Response;

class PDOServiceUnavailableException extends AbstractException
{
    public function __construct(
        $message = "PDO Service Unavailable",
        $code = Response::STATUS_CODE_503,
        \Exception $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}