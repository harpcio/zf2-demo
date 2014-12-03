<?php

namespace BusinessLogic\UsersTest\Repository;

use BusinessLogic\Users\Repository\UsersRepository;
use LibraryTest\Repository\AbstractRepositoryTestCase;

class UserRepositoryTest extends AbstractRepositoryTestCase
{
    /**
     * @var UsersRepository
     */
    private $testedObject;

    public function setUp()
    {
        parent::setUp();

        $this->testedObject = new UsersRepository($this->entityManagerMock, $this->classMetadataMock);
    }

    public function testConstructor()
    {
        $this->assertInstanceOf(UsersRepository::class, $this->testedObject);
    }
}