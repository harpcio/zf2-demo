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

namespace LibraryTest\Repository;

use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use PHPUnit_Framework_MockObject_MockObject as MockObject;

abstract class AbstractRepositoryTestCase extends \PHPUnit_Framework_TestCase
{
    /**
     * @var MockObject
     */
    protected $entityManagerMock;

    /**
     * @var MockObject
     */
    protected $classMetadataMock;

    /**
     * @var MockObject
     */
    protected $queryBuilderMock;

    /**
     * @var MockObject
     */
    protected $queryMock;

    public function setUp()
    {
        $this->entityManagerMock = $this->getMockBuilder(EntityManager::class)
            ->disableOriginalConstructor()
            ->setMethods(['persist', 'flush', 'remove', 'getClassMetadata', 'createQueryBuilder'])
            ->getMock();

        $this->classMetadataMock = $this->getMockBuilder(ClassMetadata::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->queryBuilderMock = $this->getMockBuilder(QueryBuilder::class)
            ->setMethods(['__construct', 'getQuery'])
            ->setConstructorArgs([$this->entityManagerMock])
            ->getMock();

        $this->queryMock = $this->getMockBuilder(AbstractQuery::class)
            ->setMethods(['getResult'])
            ->disableOriginalConstructor()
            ->getMockForAbstractClass();

        $this->queryBuilderMock->expects($this->any())
            ->method('getQuery')
            ->will($this->returnValue($this->queryMock));

        $this->entityManagerMock->expects($this->any())
            ->method('createQueryBuilder')
            ->will($this->returnValue($this->queryBuilderMock));

        $this->entityManagerMock->expects($this->any())
            ->method('getClassMetadata')
            ->will($this->returnValue($this->classMetadataMock));
    }

    /**
     * @param QueryBuilder $qb
     *
     * @return string
     */
    public function getRawSQLFromORMQueryBuilder(QueryBuilder $qb)
    {
        $sql = $qb->getDQL();
        $parameters = $qb->getParameters();

        /** @var Query\Parameter $param */
        foreach ($parameters as $param) {
            if (is_array($param->getValue()) && !empty($param->getValue())) {
                $sql = str_replace(':' . $param->getName(), "'" . implode("', '", $param->getValue()) . "'", $sql);
            } else {
                $sql = str_replace(':' . $param->getName(), "'" . $param->getValue() . "'", $sql);
            }
        }

        return $sql;
    }

}