<?php

namespace Library\Service\Book;

use Application\Library\QueryFilter\QueryFilter;
use Application\Library\Repository\Command\CommandCollection;
use Doctrine\ORM\Query;
use Library\Entity\BookEntity;
use Library\Repository\BookRepositoryInterface;

class FilterResultsService
{

    /**
     * @var BookRepositoryInterface
     */
    private $bookRepository;

    /**
     * @var CommandCollection
     */
    private $commandCollection;

    public function __construct(BookRepositoryInterface $bookRepository, CommandCollection $commandCollection)
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
        return $this->bookRepository->findByQueryFilter($queryFilter, $this->commandCollection, $hydrationMode);
    }
}