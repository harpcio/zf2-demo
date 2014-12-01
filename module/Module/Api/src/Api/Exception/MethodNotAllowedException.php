<?php

namespace Module\Api\Exception;

use Zend\Http\Response;

class MethodNotAllowedException extends AbstractException
{
    public function __construct(
        $message = "The resource doesn't support the specified HTTP verb.",
        $code = Response::STATUS_CODE_405,
        \Exception $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}