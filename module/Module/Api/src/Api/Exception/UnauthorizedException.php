<?php

namespace Module\Api\Exception;

use Zend\Http\Response;

class UnauthorizedException extends AbstractException
{
    public function __construct(
        $message = "Authorization Required",
        $code = Response::STATUS_CODE_401,
        \Exception $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}