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

use ApplicationLibrary\QueryFilter\Exception\UnsupportedTypeException;
use ApplicationLibrary\QueryFilter\QueryFilter;
use ApplicationLibrary\QueryFilter\Command\Repository\CommandCollection;
use Doctrine\Common\Persistence\ObjectRepository;
use BusinessLogicDomainBooks\Entity\BookEntity;

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
     * @param \ApplicationLibrary\QueryFilter\Command\Repository\CommandCollection $criteriaCommands
     * @param int                                                                   $hydrationMode
     *
     * @return array|BookEntity[]
     * @throws UnsupportedTypeException
     */
    public function findByQueryFilter(QueryFilter $queryFilter, CommandCollection $criteriaCommands, $hydrationMode);

}