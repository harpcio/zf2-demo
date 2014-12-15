<?php

namespace Module\ApiTest\Fixture;

use Module\Api\Controller\AbstractRestfulJsonController;
use Zend\Http\Request;

class SampleRestfulJsonController extends AbstractRestfulJsonController
{

    /**
     * @return array
     */
    protected function getCollectionOptions()
    {
        return [
            Request::METHOD_DELETE,
            Request::METHOD_GET,
            Request::METHOD_HEAD,
            Request::METHOD_OPTIONS,
            Request::METHOD_PATCH,
            Request::METHOD_POST,
            Request::METHOD_PUT,
            Request::METHOD_TRACE,
        ];
    }

    /**
     * @return array
     */
    protected function getResourceOptions()
    {
        return [
            Request::METHOD_DELETE,
            Request::METHOD_GET,
            Request::METHOD_HEAD,
            Request::METHOD_OPTIONS,
            Request::METHOD_PATCH,
            Request::METHOD_POST,
            Request::METHOD_PUT,
            Request::METHOD_TRACE,
        ];
    }

}