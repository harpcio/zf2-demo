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

namespace ApplicationFeatureLibraryBooks\Service;

use BusinessLogicDomainBooks\Entity\BookEntity;
use BusinessLogicDomainBooks\Repository\BooksRepositoryInterface;
use BusinessLogicLibrary\QueryFilter\QueryFilter;
use BusinessLogicLibrary\QueryFilter\Command\Repository\CommandCollection;
use BusinessLogicLibrary\QueryFilter\QueryFilterVisitor;
use Doctrine\ORM\Query;

class FilterResultsService
{

    /**
     * @var BooksRepositoryInterface
     */
    private $bookRepository;

    /**
     * @var CommandCollection
     */
    private $commandCollection;

    public function __construct(BooksRepositoryInterface $bookRepository, CommandCollection $commandCollection)
    {
        $this->bookRepository = $bookRepository;
        $this->commandCollection = $commandCollection;
    }

    /**
     * @param QueryFilter $queryFilter
     * @param int         $hydrationMode
     *
     * @return BookEntity[]|null
     */
    public function getFilteredResults(QueryFilter $queryFilter, $hydrationMode = Query::HYDRATE_OBJECT)
    {
        $queryBuilderVisitor = new QueryFilterVisitor($queryFilter, $this->commandCollection);

        return $this->bookRepository->findByQueryFilter($queryBuilderVisitor, $hydrationMode);
    }
}