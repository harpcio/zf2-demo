<?php

namespace Api\Controller;

use Api\Exception;
use Zend\Mvc\Controller\AbstractRestfulController;

class NotFoundController extends AbstractRestfulController
{
    public function notFoundAction()
    {
        throw new Exception\NotFoundException();
    }
}