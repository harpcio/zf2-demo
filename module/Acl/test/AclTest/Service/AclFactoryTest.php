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

namespace AclTest\Service;

use Acl\Service\AclFactory;
use BusinessLogic\Users\Entity\UserEntityInterface;
use Test\Bootstrap;
use Zend\Permissions\Acl\Acl;

class AclFactoryTest extends \PHPUnit_Framework_TestCase
{
    const MODULE_A = 'ModuleA',
        MODULE_B = 'ModuleB\\subB',
        MODULE_C = 'ModuleC\\subC\\subc',
        MODULE_D = 'ModuleD';


    const PRIVILEGE_A = 'ControllerA',
        PRIVILEGE_B = 'ControllerB:actionb',
        PRIVILEGE_C = 'controllerc:actionc';

    /**
     * @var AclFactory
     */
    private $testedObject;

    public function setUp()
    {
        $this->testedObject = new AclFactory($this->getModules(), $this->getAclConfig());
    }

    public function testCreate()
    {
        $result = $this->testedObject->create();

        $this->assertInstanceOf(Acl::class, $result);
        $this->assertCount(count(array_keys($this->getModules())), $result->getResources());
        $this->assertCount(count(array_keys($this->getAclConfig())), $result->getRoles());
    }

    private function getModules()
    {
        return [
            self::MODULE_A,
            self::MODULE_B,
            self::MODULE_C,
            self::MODULE_D
        ];
    }

    private function getAclConfig()
    {
        return [
            UserEntityInterface::ROLE_GUEST => [
                'parents' => [],
                'allow' => [
                    self::MODULE_A => [],
                    self::MODULE_B => [
                        self::PRIVILEGE_B,
                        self::PRIVILEGE_C
                    ],
                    self::MODULE_D => []
                ],
                'deny' => []
            ],
            UserEntityInterface::ROLE_ADMIN => [
                'parents' => ['guest'],
                'allow' => [
                    self::MODULE_B => [
                        self::PRIVILEGE_A
                    ],
                    self::MODULE_C => [
                        self::PRIVILEGE_A,
                        self::PRIVILEGE_B,
                    ]
                ],
                'deny' => [
                    self::MODULE_B => [
                        self::PRIVILEGE_C,
                    ],
                    self::MODULE_D => []
                ]
            ]
        ];
    }

    /**
     * @dataProvider dataProviderForTestCreatedAclIsAllowedTo
     *
     * @param bool   $expectedResult
     * @param string $role
     * @param string $resource
     * @param string $privilege
     */
    public function testCreatedAclIsAllowedTo($expectedResult, $role, $resource, $privilege)
    {
        $acl = $this->testedObject->create();

        $result = $acl->isAllowed(strtolower($role), strtolower($resource), strtolower($privilege));

        $this->assertSame($expectedResult, $result);
    }

    public function dataProviderForTestCreatedAclIsAllowedTo()
    {
        return [
            // module A

            'guest should have access to ANY privilege (A) in module A' => [
                true,
                UserEntityInterface::ROLE_GUEST,
                self::MODULE_A,
                self::PRIVILEGE_A
            ],
            'guest should have access to ANY privilege (B) in module A' => [
                true,
                UserEntityInterface::ROLE_GUEST,
                self::MODULE_A,
                self::PRIVILEGE_B
            ],
            'guest should have access to ANY privilege (C) in module A' => [
                true,
                UserEntityInterface::ROLE_GUEST,
                self::MODULE_A,
                self::PRIVILEGE_C
            ],
            'admin should have access to ANY privilege (A) in module A' => [
                true,
                UserEntityInterface::ROLE_ADMIN,
                self::MODULE_A,
                self::PRIVILEGE_A
            ],
            'admin should have access to ANY privilege (B) in module A' => [
                true,
                UserEntityInterface::ROLE_ADMIN,
                self::MODULE_A,
                self::PRIVILEGE_B
            ],
            'admin should have access to ANY privilege (C) in module A' => [
                true,
                UserEntityInterface::ROLE_ADMIN,
                self::MODULE_A,
                self::PRIVILEGE_C
            ],
            // module B

            'guest should have access to privilege B in module B' => [
                true,
                UserEntityInterface::ROLE_GUEST,
                self::MODULE_B,
                self::PRIVILEGE_B
            ],
            'guest should have access to privilege C in module B' => [
                true,
                UserEntityInterface::ROLE_GUEST,
                self::MODULE_B,
                self::PRIVILEGE_C
            ],
            'admin should have access to privilege A in module B' => [
                true,
                UserEntityInterface::ROLE_ADMIN,
                self::MODULE_B,
                self::PRIVILEGE_A
            ],
            'admin should have access to privilege B in module B' => [
                true,
                UserEntityInterface::ROLE_ADMIN,
                self::MODULE_B,
                self::PRIVILEGE_B
            ],
            'admin shouldn\'t have access to privilege C in module B' => [
                false,
                UserEntityInterface::ROLE_ADMIN,
                self::MODULE_B,
                self::PRIVILEGE_C
            ],
            // module C

            'guest shouldn\'t have access to ANY privilege (A) in module C' => [
                false,
                UserEntityInterface::ROLE_GUEST,
                self::MODULE_C,
                self::PRIVILEGE_A
            ],
            'guest shouldn\'t have access to ANY privilege (B) in module C' => [
                false,
                UserEntityInterface::ROLE_GUEST,
                self::MODULE_C,
                self::PRIVILEGE_B
            ],
            'guest shouldn\'t have access to ANY privilege (C) in module C' => [
                false,
                UserEntityInterface::ROLE_GUEST,
                self::MODULE_C,
                self::PRIVILEGE_C
            ],
            'admin should have access to privilege A in module C' => [
                true,
                UserEntityInterface::ROLE_ADMIN,
                self::MODULE_C,
                self::PRIVILEGE_A
            ],
            'admin should have access to privilege B in module C' => [
                true,
                UserEntityInterface::ROLE_ADMIN,
                self::MODULE_C,
                self::PRIVILEGE_B
            ],
            'admin shouldn\'t have access to privilege C in module C' => [
                false,
                UserEntityInterface::ROLE_ADMIN,
                self::MODULE_C,
                self::PRIVILEGE_C
            ],
            // Module D
            'guest should have access to ANY privilege (A) in module D' => [
                true,
                UserEntityInterface::ROLE_GUEST,
                self::MODULE_D,
                self::PRIVILEGE_A
            ],
            'guest should have access to ANY privilege (B) in module D' => [
                true,
                UserEntityInterface::ROLE_GUEST,
                self::MODULE_D,
                self::PRIVILEGE_B
            ],
            'guest should have access to ANY privilege (C) in module D' => [
                true,
                UserEntityInterface::ROLE_GUEST,
                self::MODULE_D,
                self::PRIVILEGE_C
            ],
            'admin shouldn\'t have access to privilege A in module D' => [
                false,
                UserEntityInterface::ROLE_ADMIN,
                self::MODULE_D,
                self::PRIVILEGE_A
            ],
            'admin shouldn\'t have access to privilege B in module D' => [
                false,
                UserEntityInterface::ROLE_ADMIN,
                self::MODULE_D,
                self::PRIVILEGE_B
            ],
            'admin shouldn\'t have access to privilege C in module D' => [
                false,
                UserEntityInterface::ROLE_ADMIN,
                self::MODULE_D,
                self::PRIVILEGE_C
            ],
        ];
    }

}