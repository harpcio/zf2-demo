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

namespace ApplicationFeatureLibraryBooks\Controller;

use ApplicationLibrary\QueryFilter\Exception\UnrecognizedFieldException;
use ApplicationLibrary\QueryFilter\Exception\UnsupportedTypeException;
use ApplicationLibrary\QueryFilter\QueryFilter;
use ApplicationFeatureLibraryBooks\Service\FilterResultsService;
use Zend\Mvc\Controller\AbstractActionController;

class IndexController extends AbstractActionController
{
    /**
     * @var FilterResultsService
     */
    private $service;

    /**
     * @var QueryFilter
     */
    private $queryFilter;

    public function __construct(FilterResultsService $service, QueryFilter $queryFilter)
    {
        $this->service = $service;
        $this->queryFilter = $queryFilter;
    }

    public function indexAction()
    {
        $books = [];

        try {
            $this->queryFilter->setQueryParameters($this->params()->fromQuery());

            $books = $this->service->getFilteredResults($this->queryFilter);
        } catch (UnrecognizedFieldException $e) {
            $this->flashMessenger()->addErrorMessage($e->getMessage());
        } catch (UnsupportedTypeException $e) {
            $this->flashMessenger()->addErrorMessage($e->getMessage());
        }

        return [
            'books' => $books
        ];
    }
}