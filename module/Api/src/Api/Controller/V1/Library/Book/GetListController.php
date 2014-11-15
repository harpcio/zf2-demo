<?php

namespace Api\Controller\V1\Library\Book;

use Application\Library\QueryFilter\Exception\UnrecognizedFieldException;
use Application\Library\QueryFilter\Exception\UnsupportedTypeException;
use Application\Library\QueryFilter\QueryFilter;
use Library\Entity\BookEntity;
use Library\Service\Book\CrudService;
use Zend\Http\Response;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;
use Api\Exception;

class GetListController extends AbstractActionController
{

    /**
     * @var CrudService
     */
    private $service;

    /**
     * @var QueryFilter
     */
    private $queryFilter;

    public function __construct(CrudService $service, QueryFilter $queryFilter)
    {
        $this->service = $service;
        $this->queryFilter = $queryFilter;
    }

    public function indexAction()
    {
        try {
            $this->queryFilter->setQueryParameters($this->params()->fromQuery());
            $books = $this->service->getFilteredResults($this->queryFilter);
            $data = [];

            /** @var BookEntity $bookEntity */
            foreach ($books as $bookEntity) {
                $data[] = $this->service->extractEntity($bookEntity);
            }

            return new JsonModel(['data' => $data]);
        } catch (UnrecognizedFieldException $e) {
            throw new Exception\BadRequestException($e->getMessage(), Response::STATUS_CODE_400, $e);
        } catch (UnsupportedTypeException $e) {
            throw new Exception\BadRequestException($e->getMessage(), Response::STATUS_CODE_400, $e);
        } catch (\PDOException $e) {
            throw new Exception\PDOServiceUnavailableException();
        }
    }
}