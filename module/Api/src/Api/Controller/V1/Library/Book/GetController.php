<?php

namespace Api\Controller\V1\Library\Book;

use Api\Exception;
use Doctrine\ORM\EntityNotFoundException;
use Library\Service\Book\CrudService;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;

class GetController extends AbstractActionController
{

    /**
     * @var CrudService
     */
    private $service;

    public function __construct(CrudService $service)
    {
        $this->service = $service;
    }

    public function indexAction()
    {
        $id = $this->params()->fromRoute('id', null);

        try {
            $bookEntity = $this->service->getById($id);

            $data = $this->service->extractEntity($bookEntity);

            return new JsonModel($data);
        } catch (EntityNotFoundException $e) {
            throw new Exception\NotFoundException();
        } catch (\PDOException $e) {
            throw new Exception\PDOServiceUnavailableException();
        }
    }
}