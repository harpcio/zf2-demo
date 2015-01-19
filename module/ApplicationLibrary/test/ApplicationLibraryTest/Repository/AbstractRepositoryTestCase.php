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

namespace ApplicationLibraryTest\Repository;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Platforms\MySqlPlatform;
use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\Configuration;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use DoctrineORMModule\Service\ConfigurationFactory;
use PHPUnit_Framework_MockObject_MockObject as MockObject;
use Test\Bootstrap;

abstract class AbstractRepositoryTestCase extends \PHPUnit_Framework_TestCase
{
    /**
     * @var MockObject|EntityManager
     */
    protected $entityManagerMock;

    /**
     * @var MockObject|ClassMetadata
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
        $connection = $this->getMockBuilder(Connection::class)
            ->disableOriginalConstructor()
            ->getMock();

        $connection->expects($this->any())
            ->method('getDatabasePlatform')
            ->willReturn(new MySqlPlatform());

        $this->entityManagerMock = $this->getMockBuilder(EntityManager::class)
            ->disableOriginalConstructor()
            ->setMethods(['persist', 'flush', 'remove', 'getConnection', 'getClassMetadata', 'createQueryBuilder', 'getConfiguration'])
            ->getMock();

        $this->queryBuilderMock = $this->getMockBuilder(QueryBuilder::class)
            ->setMethods(['__construct'])
            ->setConstructorArgs([$this->entityManagerMock])
            ->getMock();

        $this->queryMock = $this->getMockBuilder(AbstractQuery::class)
            ->setMethods(['getResult'])
            ->disableOriginalConstructor()
            ->getMockForAbstractClass();

        $this->queryBuilderMock->expects($this->any())
            ->method('getQuery')
            ->willReturn($this->queryMock);

        $this->entityManagerMock->expects($this->any())
            ->method('createQueryBuilder')
            ->willReturn($this->queryBuilderMock);

        $this->entityManagerMock->expects($this->any())
            ->method('getConnection')
            ->willReturn($connection);

        $configurationFactory = new ConfigurationFactory('orm_default');
        /** @var Configuration $configuration */
        $configuration = $configurationFactory->createService(clone Bootstrap::getServiceManager());

        $this->entityManagerMock->expects($this->any())
            ->method('getConfiguration')
            ->willReturn($configuration);
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