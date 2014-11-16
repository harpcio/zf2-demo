<?php

namespace ApplicationTest\Library;

use Application\Library\QueryFilter\Condition;
use Application\Library\QueryFilter\QueryFilter;
use Application\Library\QueryFilter\Command;

class QueryFilterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var QueryFilter
     */
    private $testedObject;

    public function setUp()
    {
        $this->testedObject = new QueryFilter(
            [
                new Command\Special\SortCommand(),
                new Command\Special\LimitCommand(),
                new Command\Special\OffsetCommand(),
            ],
            [
                new Command\Criteria\BetweenCommand(),
                new Command\Criteria\MinMaxCommand(),
                new Command\Criteria\StartsEndsWithCommand(),
                new Command\Criteria\EqualCommand(),
                new Command\Criteria\InArrayCommand() // this must the last command
            ]
        );
    }

    public function testSetQueryWithCollection()
    {
        $data = [
            'color' => 'red,blue,white'
        ];

        $this->testedObject->setQueryParameters($data);

        $result = $this->testedObject->getCriteria();

        $this->assertArrayHasKey('color', $result);
        /** @var Condition $condition */
        $condition = $result['color'];
        $this->assertSame(Condition::TYPE_IN_ARRAY, $condition->getType());
        $this->assertSame(['red', 'blue', 'white'], $condition->getData());
    }

    public function testSetQueryWithCollectionAndSpecialUrlCharacters()
    {
        $data = [
            'color' => ' red,% +blue+%25,white%'
        ];

        $this->testedObject->setQueryParameters($data);

        $resultCriteria = $this->testedObject->getCriteria();

        $this->assertArrayHasKey('color', $resultCriteria);
        /** @var Condition $condition */
        $condition = $resultCriteria['color'];

        $this->assertSame(Condition::TYPE_IN_ARRAY, $condition->getType());
        $this->assertSame(['red', '%  blue %', 'white%'], $condition->getData());
    }

    public function testSetQueryWithLimitAndOffset()
    {
        $data = [
            '$limit' => '100',
            '$offset' => '99'
        ];

        $this->testedObject->setQueryParameters($data);

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
            '$sort' => '-author,title',
        ];

        $this->testedObject->setQueryParameters($data);

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