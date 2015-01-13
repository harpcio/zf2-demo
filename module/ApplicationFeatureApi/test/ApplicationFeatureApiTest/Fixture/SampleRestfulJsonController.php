<?php
/**
 * This file is part of Zf2-demo package
 *
 * @author Rafal Ksiazek <harpcio@gmail.com>
 * @copyright Rafal Ksiazek F.H.U. Studioars
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ApplicationFeatureApiTest\Fixture;

use ApplicationFeatureApi\Controller\AbstractRestfulJsonController;
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