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

namespace AclTest\Service\Listener;

use Acl\Service\AclService;
use Acl\Service\Listener\CheckAccessListener;
use PHPUnit_Framework_MockObject_MockObject as MockObject;
use Zend\Mvc\MvcEvent;

class CheckAccessListenerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var CheckAccessListener
     */
    private $testedObject;

    /**
     * @var MockObject
     */
    private $checkAclServiceMock;

    public function setUp()
    {
        $this->checkAclServiceMock = $this->getMockBuilder(AclService::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->testedObject = new CheckAccessListener($this->checkAclServiceMock);
    }

    public function testInvoke()
    {
        $event = new MvcEvent();

        $this->checkAclServiceMock->expects($this->once())
            ->method('checkAccess')
            ->with($event);

        $this->testedObject->__invoke($event);
    }
}