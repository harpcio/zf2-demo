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

namespace ApplicationDataAccessDoctrineORMLibraryTest\QueryFilter\Command\Repository;

use ApplicationDataAccessDoctrineORMLibrary\QueryFilter\Command\Repository\FieldsCommand;
use BusinessLogicLibrary\QueryFilter\Criteria;
use Doctrine\DBAL\Query\QueryBuilder;
use Doctrine\ORM\Query\Expr;
use PHPUnit_Framework_MockObject_MockObject as MockObject;

class FieldsCommandTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var FieldsCommand
     */
    private $testedObject;

    public function setUp()
    {
        $this->testedObject = new FieldsCommand();
    }

    public function testExecute_WhenCriteriaType_IsNotMatch()
    {
        $queryBuilder = 'can be anything';
        $criteria = new Criteria(Criteria::TYPE_CONDITION_EQUAL, null, 'something');

        $result = $this->testedObject->execute($queryBuilder, $criteria);

        $this->assertFalse($result);
    }

    public function testExecute()
    {
        /** @var MockObject|QueryBuilder $queryBuilder */
        $queryBuilder = $this->getMockBuilder(QueryBuilder::class)
            ->disableOriginalConstructor()
            ->setMethods(['getRootAliases', 'expr'])
            ->getMock();

        $queryBuilder->expects($this->once())
            ->method('getRootAliases')
            ->willReturn(['t']);

        $criteria = new Criteria(Criteria::TYPE_SPECIAL_FIELDS, ['columnName1', 'columnName2'], null);

        $result = $this->testedObject->execute($queryBuilder, $criteria);

        $this->assertTrue($result);
        $this->assertSame(['t.columnName1', 't.columnName2'], $queryBuilder->getQueryPart('select'));
    }
}