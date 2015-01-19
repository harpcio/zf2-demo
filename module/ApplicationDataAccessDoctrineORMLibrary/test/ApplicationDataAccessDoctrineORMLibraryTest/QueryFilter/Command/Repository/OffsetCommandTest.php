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

use ApplicationDataAccessDoctrineORMLibrary\QueryFilter\Command\Repository\OffsetCommand;
use BusinessLogicLibrary\QueryFilter\Criteria;
use Doctrine\DBAL\Query\QueryBuilder;
use Doctrine\ORM\Query\Expr;
use PHPUnit_Framework_MockObject_MockObject as MockObject;

class OffsetCommandTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var OffsetCommand
     */
    private $testedObject;

    public function setUp()
    {
        $this->testedObject = new OffsetCommand();
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
        $offset = mt_rand(1, 100);

        /** @var MockObject|QueryBuilder $queryBuilder */
        $queryBuilder = $this->getMockBuilder(QueryBuilder::class)
            ->disableOriginalConstructor()
            ->setMethods(['getRootAliases', 'expr'])
            ->getMock();

        $criteria = new Criteria(Criteria::TYPE_SPECIAL_OFFSET, null, $offset);

        $result = $this->testedObject->execute($queryBuilder, $criteria);

        $this->assertTrue($result);
        $this->assertSame($offset, $queryBuilder->getFirstResult());
    }
}