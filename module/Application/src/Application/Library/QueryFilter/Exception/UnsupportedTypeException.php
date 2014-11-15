<?php

namespace Application\Library\QueryFilter\Exception;

use Zend\Http\Response;

class UnsupportedTypeException extends \InvalidArgumentException
{
    public function __construct($message = '', $code = Response::STATUS_CODE_400, \Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}