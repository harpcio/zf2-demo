<?php

namespace Module\ApiV1LibraryBooks\Controller;

use Module\Api\Controller\AbstractRestfulJsonController;

class BooksController extends AbstractRestfulJsonController
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