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

namespace ApplicationFeatureApiV1LibraryBooksTest\Controller\SLFactory;

use ApplicationFeatureApiV1LibraryBooks\Controller\DeleteController;
use ApplicationFeatureApiV1LibraryBooks\Controller\SLFactory\DeleteControllerSLFactory;
use Test\Bootstrap;
use Zend\Mvc\Controller\ControllerManager;

class DeleteControllerSLFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var DeleteControllerSLFactory
     */
    private $testedObj;

    public function setUp()
    {
        $this->testedObj = new DeleteControllerSLFactory();
    }

    public function testCreateService()
    {
        $controllerManager = new ControllerManager();
        $controllerManager->setServiceLocator(Bootstrap::getServiceManager());

        $result = $this->testedObj->createService($controllerManager);

        $this->assertInstanceOf(DeleteController::class, $result);
    }
}