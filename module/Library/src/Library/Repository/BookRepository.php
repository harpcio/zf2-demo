<?php

namespace Library\Repository;

use Application\Library\QueryFilter\Condition;
use Application\Library\QueryFilter\Exception\UnsupportedTypeException;
use Application\Library\QueryFilter\QueryFilter;
use Application\Library\Traits\DoctrineHydratorAwareInterface;
use Application\Library\Traits\DoctrineHydratorAwareTrait;
use Doctrine\ORM\EntityRepository;
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
     * @param QueryFilter $queryFilter
     *
     * @return array|BookEntity[]
     * @throws UnsupportedTypeException
     */
    public function findByQueryFilter(QueryFilter $queryFilter)
    {
        $i = 0;
        $bookTableAlias = 'b';
        $qb = $this->createQueryBuilder($bookTableAlias);

        /** @var $condition Condition */
        foreach ($queryFilter->getCriteria() as $columnName => $condition) {
            $preparedColumnName = $this->prepareColumnName($bookTableAlias, $columnName);
            switch ($condition->getType()) {
                case Condition::TYPE_BETWEEN:
                    $paramLeft = ':betweenLeft' . $i;
                    $paramRight = ':betweenRight' . $i;
                    $qb->andWhere($qb->expr()->between($preparedColumnName, $paramLeft, $paramRight))
                        ->setParameters(
                            [
                                $paramLeft => $condition->getData()[0],
                                $paramRight => $condition->getData()[1]
                            ]
                        );
                    break;

                case Condition::TYPE_MIN:
                    $param = ':min' . $i;
                    $qb->andWhere($qb->expr()->gte($preparedColumnName, $param))
                        ->setParameter($param, $condition->getData());
                    break;

                case Condition::TYPE_MAX:
                    $param = ':max' . $i;
                    $qb->andWhere($qb->expr()->lte($preparedColumnName, $param))
                        ->setParameter($param, $condition->getData());
                    break;

                case Condition::TYPE_STARTS_WITH:
                    $param = ':startsWith' . $i;
                    $qb->andWhere($qb->expr()->like($preparedColumnName, $param))
                        ->setParameter($param, $condition->getData() . '%');
                    break;

                case Condition::TYPE_ENDS_WITH:
                    $param = ':endsWith' . $i;
                    $qb->andWhere($qb->expr()->like($preparedColumnName, $param))
                        ->setParameter($param, '%' . $condition->getData());
                    break;

                case Condition::TYPE_EQUAL:
                    $param = ':eq' . $i;
                    $qb->andWhere($qb->expr()->eq($preparedColumnName, $param))
                        ->setParameter($param, $condition->getData());
                    break;

                case Condition::TYPE_IN_ARRAY:
                    $param = ':in' . $i;
                    $qb->andWhere($qb->expr()->in($preparedColumnName, $param))
                        ->setParameter($param, $condition->getData());
                    break;

                default:
                    throw new UnsupportedTypeException(sprintf(
                        'Unsupported condition type: %s',
                        $condition->getType()
                    ));
                    break;
            }
            $i += 1;
        }

        foreach ($queryFilter->getOrderBy() as $columnName => $order) {
            $preparedColumnName = $this->prepareColumnName($bookTableAlias, $columnName);
            $qb->addOrderBy($preparedColumnName, $order);
        }

        $qb->setMaxResults($queryFilter->getLimit())
            ->setFirstResult($queryFilter->getOffset());

        return $qb->getQuery()->getResult();
    }

    /**
     * @param string $alias
     * @param string $column
     *
     * @return string
     */
    private function prepareColumnName($alias, $column)
    {
        return $alias . '.' . $column;
    }
}