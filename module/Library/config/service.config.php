<?php

use Zend\ServiceManager\ServiceManager;

return [
    'service_manager' => [
        'invokables' => [
            Library\Form\Book\CreateFormInputFilter::class => Library\Form\Book\CreateFormInputFilter::class,
            Library\Form\DeleteFormInputFilter::class => Library\Form\DeleteFormInputFilter::class,
        ],
        'abstract_factories' => [
        ],
        'aliases' => [
        ],
        'factories' => [
            Library\Form\Book\CreateForm::class => function (ServiceManager $sm) {
                    /**
                     * @var $filter Library\Form\Book\CreateFormInputFilter
                     */
                    $filter = $sm->get(Library\Form\Book\CreateFormInputFilter::class);

                    $form = new Library\Form\Book\CreateForm();
                    $form->setInputfilter($filter);

                    return $form;
                },
            Library\Form\DeleteForm::class => function (ServiceManager $sm) {
                    /**
                     * @var $filter Library\Form\DeleteFormInputFilter
                     */
                    $filter = $sm->get(Library\Form\DeleteFormInputFilter::class);

                    $form = new Library\Form\DeleteForm();
                    $form->setInputfilter($filter);

                    return $form;
                },
            Library\Service\Book\CrudService::class => function (ServiceManager $sm) {
                    /**
                     * @var $em             Doctrine\ORM\EntityManager
                     * @var $bookRepository Library\Repository\BookRepository
                     */
                    $em = $sm->get(Doctrine\ORM\EntityManager::class);
                    $bookRepository = $em->getRepository(Library\Entity\BookEntity::class);

                    return new \Library\Service\Book\CrudService($bookRepository);
                },
        ],
    ]
];