<?php

namespace ApplicationTest\Library;

use Application\Library\QueryFilter\Criteria;
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
                // special
                new Command\Special\FieldsCommand(),
                new Command\Special\SortCommand(),
                new Command\Special\LimitCommand(),
                new Command\Special\OffsetCommand(),
                // condition
                new Command\Condition\BetweenCommand(),
                new Command\Condition\MinMaxCommand(),
                new Command\Condition\StartsEndsWithCommand(),
                new Command\Condition\EqualCommand(),
                new Command\Condition\InArrayCommand() // this must the last command
            ]
        );
    }

    public function testSetQueryWithCollection()
    {
        $data = [
            'color' => 'red,blue,white'
        ];

        $this->testedObject->setQueryParameters($data);

        $resultCriteria = $this->testedObject->getCriteria();

        /** @var Criteria $firstCriteria */
        $firstCriteria = $resultCriteria[0];

        $this->assertSame(Criteria::TYPE_CONDITION_IN_ARRAY, $firstCriteria->getType());
        $this->assertSame('color', $firstCriteria->getKey());
        $this->assertSame(['red', 'blue', 'white'], $firstCriteria->getValue());
    }

    public function testSetQueryWithCollectionAndSpecialUrlCharacters()
    {
        $data = [
            'color' => ' red,% +blue+%25,white%'
        ];

        $this->testedObject->setQueryParameters($data);

        $resultCriteria = $this->testedObject->getCriteria();
        /** @var Criteria $firstCriteria */
        $firstCriteria = $resultCriteria[0];

        $this->assertSame(Criteria::TYPE_CONDITION_IN_ARRAY, $firstCriteria->getType());
        $this->assertSame('color', $firstCriteria->getKey());
        $this->assertSame(['red', '%  blue %', 'white%'], $firstCriteria->getValue());
    }

    public function testSetQueryWithLimitAndOffset()
    {
        $limit = mt_rand(1, 100);
        $offset = mt_rand(1, 100);

        $data = [
            '$limit' => (string)$limit,
            '$offset' => (string)$offset
        ];

        $this->testedObject->setQueryParameters($data);

        $resultCriteria = $this->testedObject->getCriteria();
        /** @var Criteria $firstCriteria */
        $firstCriteria = $resultCriteria[0];
        /** @var Criteria $secondCriteria */
        $secondCriteria = $resultCriteria[1];

        $this->assertSame(Criteria::TYPE_SPECIAL_LIMIT, $firstCriteria->getType());
        $this->assertSame(null, $firstCriteria->getKey());
        $this->assertSame($limit, $firstCriteria->getValue());

        $this->assertSame(Criteria::TYPE_SPECIAL_OFFSET, $secondCriteria->getType());
        $this->assertSame(null, $secondCriteria->getKey());
        $this->assertSame($offset, $secondCriteria->getValue());
    }

    public function testSetQueryWithSort()
    {
        $data = [
            '$sort' => '-author,title',
        ];

        $this->testedObject->setQueryParameters($data);

        $resultCriteria = $this->testedObject->getCriteria();
        /** @var Criteria $firstCriteria */
        $firstCriteria = $resultCriteria[0];
        /** @var Criteria $secondCriteria */
        $secondCriteria = $resultCriteria[1];

        $this->assertSame(Criteria::TYPE_SPECIAL_SORT, $firstCriteria->getType());
        $this->assertSame('author', $firstCriteria->getKey());
        $this->assertSame('desc', $firstCriteria->getValue());

        $this->assertSame(Criteria::TYPE_SPECIAL_SORT, $secondCriteria->getType());
        $this->assertSame('title', $secondCriteria->getKey());
        $this->assertSame('asc', $secondCriteria->getValue());
    }

    public function testSetQueryWithMultipleOptionsInTheSameColumn()
    {
        $data = [
            'name' => [
                '$startswith("a")',
                '$endswith("z")'
            ]
        ];

        $this->testedObject->setQueryParameters($data);

        $resultCriteria = $this->testedObject->getCriteria();
        /** @var Criteria $firstCriteria */
        $firstCriteria = $resultCriteria[0];
        /** @var Criteria $secondCriteria */
        $secondCriteria = $resultCriteria[1];

        $this->assertSame(Criteria::TYPE_CONDITION_STARTS_WITH, $firstCriteria->getType());
        $this->assertSame('name', $firstCriteria->getKey());
        $this->assertSame('a', $firstCriteria->getValue());

        $this->assertSame(Criteria::TYPE_CONDITION_ENDS_WITH, $secondCriteria->getType());
        $this->assertSame('name', $secondCriteria->getKey());
        $this->assertSame('z', $secondCriteria->getValue());
    }

}