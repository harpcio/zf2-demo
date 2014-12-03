<?php

namespace Module\AuthTest\Controller;

use BusinessLogic\Users\Entity\UserEntity;
use BusinessLogic\UsersTest\Entity\Provider\UserEntityProvider;
use LibraryTest\Controller\AbstractFunctionalControllerTestCase;
use Test\Bootstrap;
use Zend\Http\Request;
use Zend\Http\Response;

class NoAccessControllerFunctionalTest extends AbstractFunctionalControllerTestCase
{
    const LOGIN_URL = '/auth/login';

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
        $this->prepareUserAuthenticationForSuperMan();
        $this->prepareConfigAclForSuperman();

        $this->dispatch(self::LOGIN_URL, Request::METHOD_GET);

        $this->assertResponseStatusCode(Response::STATUS_CODE_302);
        $this->assertRedirectTo('/auth/no-access');
    }

    private function prepareUserAuthenticationForSuperMan()
    {
        $userEntity = UserEntityProvider::createEntityWithRandomData();

        $ref = new \ReflectionClass(UserEntity::class);
        $prop = $ref->getProperty('allowedRoles');
        $prop->setAccessible(true);
        $prop->setValue($userEntity, ['admin', 'superman']);

        $userEntity->setRole('superman');

        $this->prepareAuthenticateMock(true, $userEntity);
    }

    private function prepareConfigAclForSuperman()
    {
        $config = $this->getApplicationServiceLocator()->get('Config');
        $config['acl']['superman'] = [
            'parents' => [],
            'allow' => [],
            'deny' => []
        ];

        $this->setMockToServiceLocator('Config', $config);
    }
}