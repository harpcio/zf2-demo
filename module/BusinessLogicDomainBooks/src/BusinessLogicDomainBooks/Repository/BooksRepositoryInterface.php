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

use BusinessLogicDomainBooks\Entity\BookEntity;
use BusinessLogicLibrary\Pagination\PaginatorAdapter;
use BusinessLogicLibrary\QueryFilter\Exception\UnsupportedTypeException;
use BusinessLogicLibrary\QueryFilter\QueryFilterVisitorInterface;
use Doctrine\Common\Persistence\ObjectRepository;

interface BooksRepositoryInterface extends ObjectRepository
{
    /**
     * @return BookEntity
     */
    public function createNewEntity();

    /**
     * @param BookEntity $bookEntity
     * @param array      $data
     *
     * @return BookEntity
     */
    public function hydrate(BookEntity $bookEntity, array $data);

    /**
     * @param BookEntity $bookEntity
     *
     * @return array
     */
    public function extract(BookEntity $bookEntity);

    /**
     * @param BookEntity $bookEntity
     * @param bool       $flush
     */
    public function save(BookEntity $bookEntity, $flush = true);

    /**
     * @param BookEntity $bookEntity
     * @param bool       $flush
     */
    public function delete(BookEntity $bookEntity, $flush = true);

    /**
     * @param QueryFilterVisitorInterface $queryFilterVisitor
     * @param int                         $hydrationMode
     *
     * @return PaginatorAdapter
     * @throws UnsupportedTypeException
     */
    public function findByQueryFilter(QueryFilterVisitorInterface $queryFilterVisitor, $hydrationMode);

}