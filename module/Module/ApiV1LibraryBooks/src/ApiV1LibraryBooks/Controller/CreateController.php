<?php

namespace Module\ApiV1LibraryBooks\Controller;

use Module\Api\Controller\AbstractApiActionController;
use Module\Api\Exception;
use Module\LibraryBooks\Form\CreateFormInputFilter;
use Module\LibraryBooks\Service\CrudService;
use Zend\Http\Request;
use Zend\Http\Response;
use Zend\View\Model\JsonModel;

class CreateController extends AbstractApiActionController
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
        /**
         * @var Request  $request
         * @var Response $response
         */
        $request = $this->getRequest();
        $response = $this->getResponse();

        $this->filter->setData($request->getPost()->toArray());

        if (!$this->filter->isValid()) {
            $messages = $this->filter->getMessages();
            $response->setStatusCode(Response::STATUS_CODE_400);

            return new JsonModel([
                'error' => [
                    'messages' => $messages
                ]
            ]);
        }

        try {
            $bookEntity = $this->service->create($this->filter);
            $response->setStatusCode(Response::STATUS_CODE_201);

            return new JsonModel($this->service->extractEntity($bookEntity));
        } catch (\PDOException $e) {
            throw new Exception\PDOServiceUnavailableException();
        }
    }
}