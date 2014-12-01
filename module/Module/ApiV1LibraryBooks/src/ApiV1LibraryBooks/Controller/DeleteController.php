<?php

namespace Module\ApiV1LibraryBooks\Controller;

use Module\Api\Controller\AbstractApiActionController;
use Module\Api\Exception;
use Module\LibraryBooks\Service\CrudService;
use Doctrine\ORM\EntityNotFoundException;
use Zend\View\Model\JsonModel;

class DeleteController extends AbstractApiActionController
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
            $this->service->delete($bookEntity);
            
            return new JsonModel([
                'data' => "Books with id {$id} has been deleted"
            ]);
        } catch (EntityNotFoundException $e) {
            throw new Exception\NotFoundException();
        } catch (\PDOException $e) {
            throw new Exception\PDOServiceUnavailableException();
        }
    }
}