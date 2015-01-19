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

namespace BusinessLogicDomainUsersTest\Repository;

use BusinessLogicDomainUsers\Entity\UserEntity;
use BusinessLogicDomainUsers\Repository\UsersRepository;
use ApplicationLibraryTest\Repository\AbstractRepositoryTestCase;
use Doctrine\ORM\Mapping\ClassMetadata;

class UserRepositoryTest extends AbstractRepositoryTestCase
{
    /**
     * @var UsersRepository
     */
    private $testedObject;

    public function setUp()
    {
        parent::setUp();

        $this->classMetadataMock = $this->getMockBuilder(ClassMetadata::class)
            ->setConstructorArgs([UserEntity::class])
            ->setMethods(null)
            ->getMock();

        $this->testedObject = new UsersRepository($this->entityManagerMock, $this->classMetadataMock);
    }

    public function testConstructor()
    {
        $this->assertInstanceOf(UsersRepository::class, $this->testedObject);
    }
}