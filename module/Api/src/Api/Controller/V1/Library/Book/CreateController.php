<?php

namespace Api\Controller\V1\Library\Book;

use Api\Exception;
use Library\Form\Book\CreateFormInputFilter;
use Library\Service\Book\CrudService;
use Zend\Http\Response;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;

class CreateController extends AbstractActionController
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
        $data = $this->params()->fromRoute('data', null);

        /** @var \Zend\Http\Response $response */
        $response = $this->getResponse();

        $this->filter->setData($data);

        if ($this->filter->isValid()) {
            $bookEntity = $this->service->create($this->filter);
            $response->setStatusCode(Response::STATUS_CODE_201);

            return new JsonModel($this->service->hydrateEntity($bookEntity));
        } else {
            $messages = $this->filter->getMessages();
            $response->setStatusCode(Response::STATUS_CODE_400);

            return new JsonModel([
                'error' => [
                    'messages' => $messages
                ]
            ]);
        }
    }
}