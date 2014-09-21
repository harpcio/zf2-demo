<?php

namespace Api\Exception;

use Zend\Http\Response;

class BadRequestException extends AbstractException
{
    public function __construct($message = '', $code = Response::STATUS_CODE_400, \Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}