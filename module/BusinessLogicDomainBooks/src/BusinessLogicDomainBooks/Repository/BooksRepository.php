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

namespace BusinessLogicDomainBooks\Repository;

use BusinessLogicLibrary\Pagination\PaginatorAdapter;
use BusinessLogicLibrary\QueryFilter\QueryFilterVisitorInterface;
use BusinessLogicDomainBooks\Entity\BookEntity;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Zend\Stdlib\Hydrator\HydratorAwareInterface;
use Zend\Stdlib\Hydrator\HydratorAwareTrait;

class BooksRepository extends EntityRepository implements BooksRepositoryInterface, HydratorAwareInterface
{
    use HydratorAwareTrait;

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
        if (!($hydrator = $this->getHydrator())) {
            throw new \LogicException('Hydrator has not been injected!');
        }

        return $hydrator->hydrate($data, $bookEntity);
    }

    /**
     * @param BookEntity $bookEntity
     *
     * @return array
     */
    public function extract(BookEntity $bookEntity)
    {
        if (!($hydrator = $this->getHydrator())) {
            throw new \LogicException('Hydrator has not been injected!');
        }

        return $hydrator->extract($bookEntity);
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
     * @param QueryFilterVisitorInterface $queryFilterVisitor
     * @param int                         $hydrationMode
     *
     * @return PaginatorAdapter
     */
    public function findByQueryFilter(
        QueryFilterVisitorInterface $queryFilterVisitor,
        $hydrationMode = Query::HYDRATE_OBJECT
    ) {
        $qb = $this->provideQueryBuilderToFindByQueryFilter($queryFilterVisitor);

        $query = $qb->getQuery();
        $query->setHydrationMode($hydrationMode);

        $paginator = new Paginator($query);
        if ($hydrationMode === Query::HYDRATE_ARRAY) {
            $paginator->setUseOutputWalkers(false);
        }

        return new PaginatorAdapter($paginator);
    }

    /**
     * @param QueryFilterVisitorInterface $queryFilterVisitor
     *
     * @return \Doctrine\ORM\QueryBuilder
     */
    private function provideQueryBuilderToFindByQueryFilter(QueryFilterVisitorInterface $queryFilterVisitor)
    {
        $entityFieldNames = $this->getEntityFieldNames();

        $qb = $this->createQueryBuilder('b');

        return $queryFilterVisitor->visit($qb, $entityFieldNames);
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