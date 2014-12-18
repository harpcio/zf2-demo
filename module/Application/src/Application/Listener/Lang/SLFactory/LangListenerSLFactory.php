<?php

namespace Application\Listener\Lang\SLFactory;

use Application\Listener\Lang\LangListener;
use Application\Listener\Lang\LangRecognizer;
use Application\Listener\Lang\LangRedirector;
use Zend\Mvc\I18n\Translator;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\FactoryInterface;

class LangListenerSLFactory implements FactoryInterface
{

    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     *
     * @return LangListener
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /**
         * @var Translator     $translator
         * @var LangRecognizer $langRecognizer
         * @var LangRedirector $langRedirector
         */
        $translator = $serviceLocator->get('Translator');
        $langRecognizer = $serviceLocator->get(LangRecognizer::class);
        $langRedirector = $serviceLocator->get(LangRedirector::class);

        return new LangListener(
            $translator,
            $langRecognizer,
            $langRedirector
        );
    }
}