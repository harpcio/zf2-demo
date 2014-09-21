<?php

namespace Api\Controller\V1\Library\Book;

use Api\Exception;
use Library\Form\Book\CreateFormInputFilter;
use Library\Service\Book\CrudService;
use Zend\Http\Response;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;

class UpdateController extends AbstractActionController
{

    /**
     * @var CreateFormInputFilter
     */
    private $filter;

    /**
     * @var CrudService
     */
    private $service;

    public function __construct(CreateFormInputFilter $filter, CrudService $service)
    {
        $this->filter = $filter;
        $this->service = $service;
    }

    public function indexAction()
    {
        $id = $this->params()->fromRoute('id', null);
        $data = $this->params()->fromRoute('data', null);
        /** @var CreateFormInputFilter $filter */
        $filter = $this->getServiceLocator()->get(CreateFormInputFilter::class);
        /** @var \Zend\Http\Response $response */
        $response = $this->getResponse();

        $bookEntity = $this->service->getById($id);

        $entityData = [
            'id' => $bookEntity->getId(),
            'title' => $bookEntity->getTitle(),
            'description' => $bookEntity->getDescription(),
            'isbn' => $bookEntity->getIsbn(),
            'year' => $bookEntity->getYear(),
            'publisher' => $bookEntity->getPublisher(),
            'price' => $bookEntity->getPrice()
        ];

        $data = array_merge($entityData, $data);

        $filter->setData($data);

        if ($filter->isValid()) {
            $this->service->update($bookEntity, $filter);

            return new JsonModel($this->service->hydrateEntity($bookEntity));
        } else {
            $messages = $filter->getMessages();
            $response->setStatusCode(Response::STATUS_CODE_400);

            return new JsonModel([
                'error' => [
                    'messages' => $messages
                ]
            ]);
        }
    }
}