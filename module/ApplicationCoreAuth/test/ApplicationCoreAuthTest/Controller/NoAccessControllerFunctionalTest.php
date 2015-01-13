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

namespace ApplicationCoreAuthTest\Controller;

use ApplicationLibraryTest\Controller\AbstractFunctionalControllerTestCase;
use BusinessLogicDomainUsers\Entity\UserEntity;
use BusinessLogicDomainUsersTest\Entity\Provider\UserEntityProvider;
use Test\Bootstrap;
use Zend\Http\Request;
use Zend\Http\Response;

class NoAccessControllerFunctionalTest extends AbstractFunctionalControllerTestCase
{
    const LOGIN_URL = '/access/login',
        UNKNOWN_USER_ROLE = 'unknown';

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
        $this->prepareUserAuthenticationForUnknownRole();
        $this->prepareConfigAclForUnknownRole();

        $this->dispatch(self::LOGIN_URL, Request::METHOD_GET);

        $this->assertResponseStatusCode(Response::STATUS_CODE_302);
        $this->assertRedirectTo('/auth/no-access');
    }

    private function prepareUserAuthenticationForUnknownRole()
    {
        $userEntity = UserEntityProvider::createEntityWithRandomData();

        $ref = new \ReflectionClass(UserEntity::class);
        $prop = $ref->getProperty('allowedRoles');
        $prop->setAccessible(true);
        $prop->setValue($userEntity, ['admin', self::UNKNOWN_USER_ROLE]);

        $userEntity->setRole(self::UNKNOWN_USER_ROLE);

        $this->prepareAuthenticateMock(true, $userEntity);
    }

    private function prepareConfigAclForUnknownRole()
    {
        $config = $this->getApplicationServiceLocator()->get('Config');
        $config['acl'][self::UNKNOWN_USER_ROLE] = [
            'parents' => [],
            'allow' => [
                'ApplicationCoreAuth' => [
                    'NoAccess:index'
                ]
            ],
            'deny' => []
        ];

        $this->setMockToServiceLocator('Config', $config);
    }
}