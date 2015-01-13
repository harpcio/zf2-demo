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

namespace ApplicationTest\Controller;

use Application\Controller\IndexController;
use ApplicationLibraryTest\Controller\AbstractControllerTestCase;
use Zend\Http\Request;
use Zend\Http\Response;

class IndexControllerTest extends AbstractControllerTestCase
{
    /**
     * @var IndexController
     */
    protected $controller;

    public function setUp()
    {
        $this->init('index');

        $this->controller = new IndexController();
        $this->controller->setEvent($this->event);
    }

    public function testIndexAction_WithGetRequest()
    {
        $result = $this->controller->dispatch(new Request());

        $this->assertResponseStatusCode(Response::STATUS_CODE_200);
        $this->assertSame([], $result);
    }

}