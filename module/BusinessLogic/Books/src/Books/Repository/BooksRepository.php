<?php

namespace BusinessLogic\Books\Repository;

use Library\QueryFilter\Criteria;
use Library\QueryFilter\Exception\UnrecognizedFieldException;
use Library\QueryFilter\Exception\UnsupportedTypeException;
use Library\QueryFilter\QueryFilter;
use Library\QueryFilter\Command\Repository\CommandCollection;
use Library\QueryFilter\Command\Repository\CommandInterface;
use Library\Traits\DoctrineHydratorAwareInterface;
use Library\Traits\DoctrineHydratorAwareTrait;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;
use BusinessLogic\Books\Entity\BookEntity;

class BooksRepository extends EntityRepository implements BooksRepositoryInterface, DoctrineHydratorAwareInterface
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
        $qb = $this->provideQueryBuilderToFindByQueryFilter($queryFilter, $criteriaCommands);

        return $qb->getQuery()->getResult($hydrationMode);
    }

    /**
     * @param QueryFilter       $queryFilter
     * @param CommandCollection $criteriaCommands
     *
     * @return \Doctrine\ORM\QueryBuilder
     * @throws \Library\QueryFilter\Exception\UnsupportedTypeException
     */
    private function provideQueryBuilderToFindByQueryFilter(
        QueryFilter $queryFilter,
        CommandCollection $criteriaCommands
    ) {
        $i = 0;
        $alias = 'b';
        $qb = $this->createQueryBuilder($alias);

        $entityFieldNames = $this->getEntityFieldNames();

        /** @var $criteria Criteria */
        foreach ($queryFilter->getCriteria() as $criteria) {
            /** @var CommandInterface $command */
            foreach ($criteriaCommands as $command) {
                if ($command->execute($qb, $criteria, $entityFieldNames, $alias, $i)) {
                    $i += 1;
                    continue 2;
                }
            }

            throw new UnsupportedTypeException(sprintf(
                'Unsupported condition type: %s',
                $criteria->getType()
            ));
        }

        return $qb;
    }

    /**
     * @return array
     */
    private function getEntityFieldNames()
    {
        return $this->getEntityManager()
            ->getClassMetadata($this->getEntityName())
            ->getFieldNames();
    }

}