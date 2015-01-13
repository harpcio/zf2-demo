<?php
/**
 * This file is part of Zf2-demo package
 *
 * @author Rafal Ksiazek <harpcio@gmail.com>
 * @copyright Rafal Ksiazek F.H.U. Studioars
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Application;

use Application\Listener\Log\LogExceptionListener;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\Loader\StandardAutoloader;

class Module
{
    public function onBootstrap(MvcEvent $e)
    {
        $this->setDefaultLocaleInWhichTheApplicationIsWritten();

        $eventManager = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);

        $sharedManager = $eventManager->getSharedManager();
        $sm = $e->getApplication()->getServiceManager();

        /** @var LogExceptionListener $logExceptionListener */
        $logExceptionListener = $sm->get(LogExceptionListener::class);
        $logExceptionListener->attachShared($sharedManager);
    }

    /**
     * If you written your application in other language than english,
     * please change this locale to your default character language
     */
    private function setDefaultLocaleInWhichTheApplicationIsWritten()
    {
        \Locale::setDefault(APPLICATION_LOCALE);
    }

    public function getConfig()
    {
        return array_merge(
            include __DIR__ . '/config/module.config.php',
            include __DIR__ . '/config/controller.config.php',
            include __DIR__ . '/config/router.config.php',
            include __DIR__ . '/config/console-router.config.php',
            include __DIR__ . '/config/service.config.php',
            include __DIR__ . '/config/view.config.php',
            include __DIR__ . '/config/navigation.config.php'
        );
    }

    public function getAutoloaderConfig()
    {
        return array(
            StandardAutoloader::class => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                    __NAMESPACE__ . 'Test' => __DIR__ . '/test/' . __NAMESPACE__ . 'Test'
                ),
            ),
        );
    }

}
