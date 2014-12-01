<?php

namespace BusinessLogic\Books\Repository;

use Library\QueryFilter\Exception\UnsupportedTypeException;
use Library\QueryFilter\QueryFilter;
use Library\QueryFilter\Command\Repository\CommandCollection;
use Doctrine\Common\Persistence\ObjectRepository;
use BusinessLogic\Books\Entity\BookEntity;

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
     * @param QueryFilter                                                           $queryFilter
     * @param \Library\QueryFilter\Command\Repository\CommandCollection $criteriaCommands
     * @param int                                                                   $hydrationMode
     *
     * @return array|BookEntity[]
     * @throws UnsupportedTypeException
     */
    public function findByQueryFilter(QueryFilter $queryFilter, CommandCollection $criteriaCommands, $hydrationMode);

}