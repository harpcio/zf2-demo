<?php

namespace Application\Library\QueryFilter\Exception;

use Zend\Http\Response;

class UnrecognizedFieldException extends \Exception
{
    public function __construct($message = '', $code = Response::STATUS_CODE_400, \Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}