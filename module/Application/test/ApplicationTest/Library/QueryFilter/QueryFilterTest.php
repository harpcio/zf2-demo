<?php

namespace ApplicationTest\Library;

use Application\Library\QueryFilter\QueryFilter;

class QueryFilterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var QueryFilter
     */
    private $testedObject;

    public function setUp()
    {
        $this->testedObject = new QueryFilter();
    }

    public function testSetQueryWithCollection()
    {
        $data = [
            'color' => 'red,blue,white'
        ];

        $this->testedObject->setQuery($data);

        $result = $this->testedObject->getCriteria();

        $expected = [
            'color' => [
                'red',
                'blue',
                'white'
            ]
        ];

        $this->assertSame($expected, $result);
    }

    public function testSetQueryWithCollectionAndSpecialUrlCharacters()
    {
        $data = [
            'color' => ' red,+blue+,%25white%'
        ];

        $this->testedObject->setQuery($data);

        $result = $this->testedObject->getCriteria();

        $expected = [
            'color' => [
                'red',
                'blue',
                '%white%'
            ]
        ];

        $this->assertSame($expected, $result);
    }

    public function testSetQueryWithLimitAndOffset()
    {
        $data = [
            'limit' => '100',
            'offset' => '99'
        ];

        $this->testedObject->setQuery($data);

        $resultCriteria = $this->testedObject->getCriteria();
        $this->assertSame([], $resultCriteria);

        $resultLimit = $this->testedObject->getLimit();
        $this->assertSame(100, $resultLimit);

        $resultOffset = $this->testedObject->getOffset();
        $this->assertSame(99, $resultOffset);
    }

    public function testSetQueryWithSort()
    {
        $data = [
            'sort' => '-author,title',
        ];

        $this->testedObject->setQuery($data);

        $expected = [
            'author' => 'desc',
            'title' => 'asc'
        ];

        $resultSort = $this->testedObject->getOrderBy();
        $this->assertSame($expected, $resultSort);

        $resultCriteria = $this->testedObject->getCriteria();
        $this->assertSame([], $resultCriteria);

        $resultLimit = $this->testedObject->getLimit();
        $this->assertSame(null, $resultLimit);

        $resultOffset = $this->testedObject->getOffset();
        $this->assertSame(null, $resultOffset);
    }

}