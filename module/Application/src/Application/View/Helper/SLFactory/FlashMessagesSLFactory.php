<?php

namespace Application\View\Helper\SLFactory;

use Application\View\Helper\FlashMessages;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\View\HelperPluginManager;

class FlashMessagesSLFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     *
     * @return FlashMessages
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /** @var HelperPluginManager $serviceLocator */
        $serviceLocator = $serviceLocator->getServiceLocator();

        $flashMessenger = $serviceLocator->get('ControllerPluginManager')
            ->get('FlashMessenger');

        return new FlashMessages($flashMessenger);
    }
}