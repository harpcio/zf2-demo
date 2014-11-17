<?php

namespace Library\Repository;

use Application\Library\QueryFilter\Exception\UnsupportedTypeException;
use Application\Library\QueryFilter\QueryFilter;
use Application\Library\QueryFilter\Command\Repository\CommandCollection;
use Doctrine\Common\Persistence\ObjectRepository;
use Library\Entity\BookEntity;

interface BookRepositoryInterface extends ObjectRepository
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
     * @param QueryFilter       $queryFilter
     * @param \Application\Library\QueryFilter\Command\Repository\CommandCollection $criteriaCommands
     * @param int               $hydrationMode
     *
     * @return array|BookEntity[]
     * @throws UnsupportedTypeException
     */
    public function findByQueryFilter(QueryFilter $queryFilter, CommandCollection $criteriaCommands, $hydrationMode);

}