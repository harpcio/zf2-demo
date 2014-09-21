<?php

use Zend\Mvc\Controller\ControllerManager;

return [
    'controllers' => [
        'invokables' => [
            'Api\Controller\NotFound' => Api\Controller\NotFoundController::class,
            'Api\Controller\V1\Library\Book' => Api\Controller\V1\Library\BookController::class,
        ],
        'factories' => [
            'Api\Controller\V1\Library\Book\GetList' => function (ControllerManager $cm) {
                    /**
                     * @var $service Library\Service\Book\CrudService
                     */
                    $sm = $cm->getServiceLocator();
                    $service = $sm->get(Library\Service\Book\CrudService::class);

                    return new Api\Controller\V1\Library\Book\GetListController($service);
                },
            'Api\Controller\V1\Library\Book\Get' => function (ControllerManager $cm) {
                    /**
                     * @var $service Library\Service\Book\CrudService
                     */
                    $sm = $cm->getServiceLocator();
                    $service = $sm->get(Library\Service\Book\CrudService::class);

                    return new Api\Controller\V1\Library\Book\GetController($service);
                },
            'Api\Controller\V1\Library\Book\Create' => function (ControllerManager $cm) {
                    /**
                     * @var $service Library\Service\Book\CrudService
                     */
                    $sm = $cm->getServiceLocator();
                    $filter = $sm->get(Library\Form\Book\CreateFormInputFilter::class);
                    $service = $sm->get(Library\Service\Book\CrudService::class);

                    return new Api\Controller\V1\Library\Book\CreateController($filter, $service);
                },
            'Api\Controller\V1\Library\Book\Delete' => function (ControllerManager $cm) {
                    /**
                     * @var $service Library\Service\Book\CrudService
                     */
                    $sm = $cm->getServiceLocator();
                    $service = $sm->get(Library\Service\Book\CrudService::class);

                    return new Api\Controller\V1\Library\Book\DeleteController($service);
                },
            'Api\Controller\V1\Library\Book\Update' => function (ControllerManager $cm) {
                    /**
                     * @var $service Library\Service\Book\CrudService
                     */
                    $sm = $cm->getServiceLocator();
                    $filter = $sm->get(Library\Form\Book\CreateFormInputFilter::class);
                    $service = $sm->get(Library\Service\Book\CrudService::class);

                    return new Api\Controller\V1\Library\Book\UpdateController($filter, $service);
                },
        ],
    ]
];