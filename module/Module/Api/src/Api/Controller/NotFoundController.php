<?php

namespace Module\Api\Controller;

use Module\Api\Exception;
use Zend\Mvc\Controller\AbstractRestfulController;

class NotFoundController extends AbstractRestfulController
{
    public function notFoundAction()
    {
        throw new Exception\NotFoundException();
    }
}