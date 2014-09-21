<?php

namespace Api\Exception;

use Zend\Http\Response;

class NotFoundException extends AbstractException
{
    public function __construct(
        $message = 'The specified resource does not exist.',
        $code = Response::STATUS_CODE_404,
        \Exception $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}