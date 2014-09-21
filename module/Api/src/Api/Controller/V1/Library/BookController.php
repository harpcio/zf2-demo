<?php

namespace Api\Controller\V1\Library;

use Api\Controller\AbstractRestfulJsonController;
use Api\Exception;
use Zend\Http\Response;

class BookController extends AbstractRestfulJsonController
{
    public function getCollectionOptions()
    {
        return ['GET', 'POST', 'OPTIONS'];
    }

    public function getResourceOptions()
    {
        return ['GET', 'PUT', 'DELETE', 'OPTIONS'];
    }

}