<?php

namespace Module\ApiV1LibraryBooks\Controller;

use Module\Api\Controller\AbstractApiActionController;
use Module\Api\Exception;
use Module\LibraryBooks\Service\FilterResultsService;
use Library\QueryFilter\Exception\UnrecognizedFieldException;
use Library\QueryFilter\Exception\UnsupportedTypeException;
use Library\QueryFilter\QueryFilter;
use Doctrine\ORM\Query;
use Zend\Http\Response;
use Zend\View\Model\JsonModel;

class GetListController extends AbstractApiActionController
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
        try {
            $this->queryFilter->setQueryParameters($this->params()->fromQuery());
            $books = $this->service->getFilteredResults($this->queryFilter, $hydrationMode = Query::HYDRATE_ARRAY);

            return new JsonModel(['data' => $books]);
        } catch (UnrecognizedFieldException $e) {
            throw new Exception\BadRequestException($e->getMessage(), Response::STATUS_CODE_400, $e);
        } catch (UnsupportedTypeException $e) {
            throw new Exception\BadRequestException($e->getMessage(), Response::STATUS_CODE_400, $e);
        } catch (\PDOException $e) {
            throw new Exception\PDOServiceUnavailableException();
        }
    }
}