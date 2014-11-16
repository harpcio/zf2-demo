<?php

namespace Library\Repository;

use Application\Library\QueryFilter\Condition;
use Application\Library\QueryFilter\Exception\UnrecognizedFieldException;
use Application\Library\QueryFilter\Exception\UnsupportedTypeException;
use Application\Library\QueryFilter\QueryFilter;
use Application\Library\Repository\Command\CommandCollection;
use Application\Library\Repository\Command\CommandInterface;
use Application\Library\Traits\DoctrineHydratorAwareInterface;
use Application\Library\Traits\DoctrineHydratorAwareTrait;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;
use Library\Entity\BookEntity;

class BookRepository extends EntityRepository implements BookRepositoryInterface, DoctrineHydratorAwareInterface
{
    use DoctrineHydratorAwareTrait;

    /**
     * @return BookEntity
     */
    public function createNewEntity()
    {
        return new BookEntity();
    }

    /**
     * @param BookEntity $bookEntity
     * @param array      $data
     *
     * @return BookEntity
     */
    public function hydrate(BookEntity $bookEntity, array $data)
    {
        return $this->getHydrator()->hydrate($data, $bookEntity);
    }

    /**
     * @param BookEntity $bookEntity
     *
     * @return array
     */
    public function extract(BookEntity $bookEntity)
    {
        return $this->getHydrator()->extract($bookEntity);
    }

    /**
     * @param BookEntity $bookEntity
     * @param bool       $flush
     */
    public function save(BookEntity $bookEntity, $flush = true)
    {
        $this->getEntityManager()->persist($bookEntity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @param BookEntity $bookEntity
     * @param bool       $flush
     */
    public function delete(BookEntity $bookEntity, $flush = true)
    {
        $this->getEntityManager()->remove($bookEntity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @param QueryFilter       $queryFilter
     * @param CommandCollection $criteriaCommands
     * @param int               $hydrationMode
     *
     * @throws UnrecognizedFieldException
     * @throws UnsupportedTypeException
     * @return array|BookEntity[]
     */
    public function findByQueryFilter(
        QueryFilter $queryFilter,
        CommandCollection $criteriaCommands,
        $hydrationMode = Query::HYDRATE_OBJECT
    ) {
        $i = 0;
        $alias = 'b';
        $qb = $this->createQueryBuilder($alias);

        $entityFieldNames = $this->getEntityManager()
            ->getClassMetadata($this->getEntityName())
            ->getFieldNames();

        /** @var $condition Condition */
        foreach ($queryFilter->getCriteria() as $columnName => $condition) {
            $this->checkColumnNameInEntityFieldNames($columnName, $entityFieldNames);
            $columnNameWithAlias = $alias . '.' . $columnName;

            /** @var CommandInterface $command */
            foreach ($criteriaCommands as $command) {
                if ($command->execute($qb, $condition, $columnNameWithAlias, $i)) {
                    $i += 1;
                    continue 2;
                }
            }

            throw new UnsupportedTypeException(sprintf(
                'Unsupported condition type: %s',
                $condition->getType()
            ));
        }

        foreach ($queryFilter->getOrderBy() as $columnName => $order) {
            $this->checkColumnNameInEntityFieldNames($columnName, $entityFieldNames);
            $columnNameWithAlias = $alias . '.' . $columnName;
            $qb->addOrderBy($columnNameWithAlias, $order);
        }

        $qb->setMaxResults($queryFilter->getLimit())
            ->setFirstResult($queryFilter->getOffset());

        return $qb->getQuery()->getResult($hydrationMode);
    }

    /**
     * @param string $columnName
     * @param array  $fieldNames
     *
     * @throws UnrecognizedFieldException
     */
    private function checkColumnNameInEntityFieldNames($columnName, array $fieldNames)
    {
        if (!in_array($columnName, $fieldNames)) {
            throw new UnrecognizedFieldException(
                sprintf('Unrecognized field "%s"', $columnName)
            );
        }
    }

}