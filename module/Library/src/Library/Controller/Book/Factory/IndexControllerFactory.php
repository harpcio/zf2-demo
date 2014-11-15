<?php

namespace Library\Controller\Book\Factory;

use Application\Library\QueryFilter\QueryFilter;
use Doctrine\ORM\EntityManager;
use Library\Controller\Book\IndexController;
use Library\Entity\BookEntity;
use Library\Service\Book\CrudService;
use Zend\Mvc\Controller\ControllerManager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class IndexControllerFactory implements FactoryInterface
{

    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     *
     * @return IndexController
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /** @var ControllerManager $serviceLocator */
        $serviceLocator = $serviceLocator->getServiceLocator();

        /**
         * @var $service     CrudService
         * @var $queryFilter QueryFilter
         * @var $em          EntityManager
         */
        $service = $serviceLocator->get(CrudService::class);
        $queryFilter = $serviceLocator->get(QueryFilter::class);
        $em = $serviceLocator->get(EntityManager::class);
        $fields = $em->getClassMetadata(BookEntity::class)->getFieldNames();
        $queryFilter->setExpectedFields($fields);

        return new IndexController($service, $queryFilter);
    }
}