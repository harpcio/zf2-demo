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

namespace ApplicationFeatureAccessTest\Service;

use ApplicationFeatureAccess\Service\LogoutService;
use PHPUnit_Framework_MockObject_MockObject as MockObject;
use Zend\Authentication\AuthenticationServiceInterface;

class LogoutServiceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var LogoutService
     */
    private $testedObject;

    /**
     * @var MockObject
     */
    private $authenticationServiceMock;

    public function setUp()
    {
        $this->authenticationServiceMock = $this->getMockBuilder(AuthenticationServiceInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->testedObject = new LogoutService($this->authenticationServiceMock);
    }

    public function testLogout()
    {
        $this->authenticationServiceMock->expects($this->once())
            ->method('clearIdentity');

        $this->testedObject->logout();
    }
}