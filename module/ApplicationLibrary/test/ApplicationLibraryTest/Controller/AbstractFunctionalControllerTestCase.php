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

namespace ApplicationLibraryTest\Controller;

use BusinessLogicDomainUsers\Entity\UserEntity;
use BusinessLogicDomainUsersTest\Entity\Provider\UserEntityProvider;
use Zend\Authentication\AuthenticationService;
use Test\Bootstrap;
use Zend\ServiceManager\ServiceManager;
use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;

abstract class AbstractFunctionalControllerTestCase extends AbstractHttpControllerTestCase
{

    /**
     * @var ServiceManager
     */
    protected $serviceLocator;

    public function setUp()
    {
        $this->serviceLocator = null;

        $this->setApplicationConfig(
            Bootstrap::getConfig()
        );
        parent::setUp();

        $this->prepareAuthenticateMock();
    }

    /**
     * Set service to service locator
     *
     * @param string $name
     * @param object $object
     *
     * @return ServiceManager
     */
    protected function setMockToServiceLocator($name, $object)
    {
        if (!$this->serviceLocator) {
            $this->serviceLocator = $this->getApplicationServiceLocator();
            $this->serviceLocator->setAllowOverride(true);
        }

        $this->serviceLocator->setService($name, $object);

        return $this->serviceLocator;
    }

    /**
     * Creates and authenticates a user.
     *
     * @param array $params
     *
     * @return UserEntity
     */
    protected function authenticateUser(array $params = [])
    {
        $userEntity = UserEntityProvider::createEntityWithRandomData($params);

        $this->prepareAuthenticateMock(true, $userEntity);

        return $userEntity;
    }

    /**
     * @param bool       $hasIdentity
     * @param UserEntity $userEntity
     */
    protected function prepareAuthenticateMock($hasIdentity = false, UserEntity $userEntity = null)
    {
        $authMock = $this->getMockBuilder(AuthenticationService::class)
            ->disableOriginalConstructor()
            ->getMock();

        $authMock->expects($this->any())
            ->method('hasIdentity')
            ->will($this->returnValue($hasIdentity));

        $authMock->expects($this->any())
            ->method('getIdentity')
            ->will($this->returnValue($userEntity));

        $this->setMockToServiceLocator(AuthenticationService::class, $authMock);
    }
}