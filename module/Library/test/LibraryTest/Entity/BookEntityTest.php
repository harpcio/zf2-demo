<?php

namespace LibraryTest\Entity;

use Library\Entity\BookEntity;
use LibraryTest\Entity\Provider\BookEntityProvider;

class BookEntityTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var BookEntity
     */
    private $testedObj;

    /**
     * @var BookEntityProvider
     */
    private $bookEntityProvider;

    public function setUp()
    {
        $this->bookEntityProvider = new BookEntityProvider();

        $this->testedObj = new BookEntity();
    }

    public function testSettersAndGetters()
    {
        $bookEntity = $this->bookEntityProvider->getBookEntityWithRandomData();

        $this->testedObj->setTitle($bookEntity->getTitle())
            ->setDescription($bookEntity->getDescription())
            ->setIsbn($bookEntity->getIsbn())
            ->setPublisher($bookEntity->getPublisher())
            ->setYear($bookEntity->getYear());

        $this->assertSame($bookEntity->getTitle(), $this->testedObj->getTitle());
        $this->assertSame($bookEntity->getDescription(), $this->testedObj->getDescription());
        $this->assertSame($bookEntity->getIsbn(), $this->testedObj->getIsbn());
        $this->assertSame($bookEntity->getPublisher(), $this->testedObj->getPublisher());
        $this->assertSame($bookEntity->getYear(), $this->testedObj->getYear());

        $this->testedObj->setPrice('841,21');
        $this->assertSame(841.21, $this->testedObj->getPrice());
    }
}