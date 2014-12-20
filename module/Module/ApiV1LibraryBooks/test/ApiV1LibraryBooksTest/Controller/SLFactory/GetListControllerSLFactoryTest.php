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

namespace Module\ApiV1LibraryBooksTest\Controller\SLFactory;

use Module\ApiV1LibraryBooks\Controller\GetListController;
use Module\ApiV1LibraryBooks\Controller\SLFactory\GetListControllerSLFactory;
use Test\Bootstrap;
use Zend\Mvc\Controller\ControllerManager;

class GetListControllerSLFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var GetListControllerSLFactory
     */
    private $testedObj;

    public function setUp()
    {
        $this->testedObj = new GetListControllerSLFactory();
    }

    public function testCreateService()
    {
        $controllerManager = new ControllerManager();
        $controllerManager->setServiceLocator(Bootstrap::getServiceManager());

        $result = $this->testedObj->createService($controllerManager);

        $this->assertInstanceOf(GetListController::class, $result);
    }
}