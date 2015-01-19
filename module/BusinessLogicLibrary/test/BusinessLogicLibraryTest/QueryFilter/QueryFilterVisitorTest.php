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

namespace BusinessLogicLibraryTest\QueryFilter;

use BusinessLogicLibrary\QueryFilter\Command\Repository\CommandCollection;
use BusinessLogicLibrary\QueryFilter\Command\Repository\CommandInterface;
use BusinessLogicLibrary\QueryFilter\Criteria;
use BusinessLogicLibrary\QueryFilter\QueryFilter;
use BusinessLogicLibrary\QueryFilter\QueryFilterVisitor;
use PHPUnit_Framework_MockObject_MockObject as MockObject;

class QueryFilterVisitorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var QueryFilterVisitor
     */
    private $testedObject;

    /**
     * @var MockObject|QueryFilter
     */
    private $queryFilterMock;

    /**
     * @var MockObject|CommandCollection
     */
    private $commandCollectionMock;

    public function setUp()
    {
        $this->queryFilterMock = $this->getMockBuilder(QueryFilter::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->commandCollectionMock = $this->getMockBuilder(CommandCollection::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->testedObject = new QueryFilterVisitor(
            $this->queryFilterMock, $this->commandCollectionMock
        );
    }

    public function testVisit()
    {
        $queryBuilder = 'can be anything';
        $entityFieldNames = [
            'id',
            'title',
            'price'
        ];

        $this->queryFilterMock->expects($this->once())
            ->method('getCriteria')
            ->willReturn(
                [
                    $criteria0 = new Criteria(Criteria::TYPE_SPECIAL_FIELDS, ['id', 'title'], null),
                    $criteria1 = new Criteria(Criteria::TYPE_CONDITION_MAX, 'price', 100),
                    $criteria2 = new Criteria(Criteria::TYPE_SPECIAL_LIMIT, null, 10)
                ]
            );

        $commandMock = $this->getMock(CommandInterface::class);

        $commandMock->expects($this->at(0))
            ->method('execute')
            ->with($queryBuilder, $criteria0);

        $commandMock->expects($this->at(1))
            ->method('execute')
            ->with($queryBuilder, $criteria1);

        $commandMock->expects($this->at(2))
            ->method('execute')
            ->with($queryBuilder, $criteria2);

        $this->commandCollectionMock->expects($this->at(0))
            ->method('offsetGet')
            ->with(Criteria::TYPE_SPECIAL_FIELDS)
            ->willReturn($commandMock);

        $this->commandCollectionMock->expects($this->at(1))
            ->method('offsetGet')
            ->with(Criteria::TYPE_CONDITION_MAX)
            ->willReturn($commandMock);

        $this->commandCollectionMock->expects($this->at(2))
            ->method('offsetGet')
            ->with(Criteria::TYPE_SPECIAL_LIMIT)
            ->willReturn($commandMock);

        $result = $this->testedObject->visit($queryBuilder, $entityFieldNames);

        $this->assertSame($queryBuilder, $result);
    }

    public function testVisit_WhenFilterByColumnNameThatIsNotExistInEntity()
    {
        $queryBuilder = 'can be anything';
        $entityFieldNames = [
            'id',
            'title',
            'price'
        ];

        $this->queryFilterMock->expects($this->once())
            ->method('getCriteria')
            ->willReturn(
                [
                    $criteria0 = new Criteria(Criteria::TYPE_SPECIAL_FIELDS, ['id', 'title', 'isbn'], null),
                ]
            );

        $this->setExpectedException(
            'BusinessLogicLibrary\QueryFilter\Exception\UnrecognizedFieldException',
            'Tried to filter by field "isbn" which does not exist in entity'
        );

        $result = $this->testedObject->visit($queryBuilder, $entityFieldNames);

        $this->assertSame($queryBuilder, $result);
    }

    public function testVisit_WhenFilterByTypeThatIsNotSupported()
    {
        $queryBuilder = 'can be anything';
        $entityFieldNames = [
            'id',
            'title',
            'price'
        ];

        $criteriaMock = $this->getMockBuilder(Criteria::class)
            ->disableOriginalConstructor()
            ->getMock();

        $criteriaMock->expects($this->exactly(2))
            ->method('getType')
            ->willReturn('notSupportedType');

        $criteriaMock->expects($this->once())
            ->method('getKey')
            ->willReturn('title');

        $this->queryFilterMock->expects($this->once())
            ->method('getCriteria')
            ->willReturn(
                [
                    $criteriaMock,
                ]
            );

        $this->commandCollectionMock->expects($this->once())
            ->method('offsetGet')
            ->with('notSupportedType')
            ->willReturn(null);

        $this->setExpectedException(
            'BusinessLogicLibrary\QueryFilter\Exception\UnsupportedTypeException',
            'Tried to filter by field "notSupportedType" that is not supported'
        );

        $result = $this->testedObject->visit($queryBuilder, $entityFieldNames);

        $this->assertSame($queryBuilder, $result);
    }
}