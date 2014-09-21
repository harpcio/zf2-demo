<?php

use Zend\Mvc\Controller\ControllerManager;

return [
    'controllers' => [
        'invokables' => [
//            'Library\Controller\Index' => Library\Controller\IndexController::class,
        ],
        'factories' => [
            'Library\Controller\Book\Index' => function (ControllerManager $cm) {
                    /**
                     * @var $service Library\Service\Book\CrudService
                     */
                    $sm      = $cm->getServiceLocator();
                    $service = $sm->get(Library\Service\Book\CrudService::class);

                    return new Library\Controller\Book\IndexController($service);
                },
            'Library\Controller\Book\Create' => function (ControllerManager $cm) {
                    /**
                     * @var $service Library\Service\Book\CrudService
                     * @var $form    Library\Form\Book\CreateForm
                     */
                    $sm      = $cm->getServiceLocator();
                    $service = $sm->get(Library\Service\Book\CrudService::class);
                    $form    = $sm->get(Library\Form\Book\CreateForm::class);

                    return new Library\Controller\Book\CreateController($form, $service);
                },
            'Library\Controller\Book\Update' => function (ControllerManager $cm) {
                    /**
                     * @var $service Library\Service\Book\CrudService
                     * @var $form    Library\Form\Book\CreateForm
                     */
                    $sm      = $cm->getServiceLocator();
                    $service = $sm->get(Library\Service\Book\CrudService::class);
                    $form    = $sm->get(Library\Form\Book\CreateForm::class);

                    return new Library\Controller\Book\UpdateController($form, $service);
                },
            'Library\Controller\Book\Delete' => function (ControllerManager $cm) {
                    /**
                     * @var $service Library\Service\Book\CrudService
                     * @var $form    Library\Form\DeleteForm
                     */
                    $sm      = $cm->getServiceLocator();
                    $service = $sm->get(Library\Service\Book\CrudService::class);
                    $form    = $sm->get(Library\Form\DeleteForm::class);

                    return new Library\Controller\Book\DeleteController($form, $service);
                },
            'Library\Controller\Book\Read' => function (ControllerManager $cm) {
                    /**
                     * @var $service Library\Service\Book\CrudService
                     */
                    $sm      = $cm->getServiceLocator();
                    $service = $sm->get(Library\Service\Book\CrudService::class);

                    return new Library\Controller\Book\ReadController($service);
                }

        ],
    ]
];