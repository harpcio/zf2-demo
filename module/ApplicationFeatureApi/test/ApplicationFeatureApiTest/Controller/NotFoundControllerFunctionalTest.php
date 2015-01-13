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

namespace ApplicationFeatureApiTest\Controller;

use ApplicationLibraryTest\Controller\AbstractFunctionalControllerTestCase;
use Test\Bootstrap;
use Zend\Http\Request;
use Zend\Http\Response;

class NotFoundControllerFunctionalTest extends AbstractFunctionalControllerTestCase
{
    const NOT_EXISTING_URL = '/api/no-existing-url';

    public function setUp()
    {
        parent::setUp();
    }

    public static function tearDownAfterClass()
    {
        parent::tearDownAfterClass();

        Bootstrap::setupServiceManager();
    }

    public function testNotFoundAction()
    {
        $this->dispatch(self::NOT_EXISTING_URL, Request::METHOD_GET);

        $expectedJson = '{"errorCode":404,"message":"The specified resource does not exist."}';

        $this->assertSame($expectedJson, $this->getResponse()->getContent());
    }
}