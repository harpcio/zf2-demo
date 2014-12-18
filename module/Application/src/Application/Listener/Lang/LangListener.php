<?php

namespace Application\Listener\Lang;

use Zend\Http\Response;
use Zend\I18n\Translator\Translator;
use Zend\Mvc\MvcEvent;
use Zend\Mvc\I18n\Translator as MvcTranslator;
use Zend\Validator\AbstractValidator;

class LangListener
{
    /**
     * @var MvcTranslator
     */
    private $mvcTranslator;

    /**
     * @var LangRecognizer
     */
    private $langRecognizer;

    /**
     * @var LangRedirector
     */
    private $langRedirector;

    public function __construct(
        MvcTranslator $mvcTranslator,
        LangRecognizer $langRecognizer,
        LangRedirector $langRedirector
    ) {
        $this->mvcTranslator = $mvcTranslator;
        $this->langRecognizer = $langRecognizer;
        $this->langRedirector = $langRedirector;
    }

    /**
     * @param MvcEvent $event
     *
     * @return MvcEvent
     */
    public function __invoke(MvcEvent $event)
    {
        if (!($result = $this->langRecognizer->recognize($event))) {
            return false;
        }

        list($lang, $newLocale, $routeMatchLang) = $result;

        if (($result = $this->langRedirector->checkRedirect($event, $lang, $routeMatchLang))) {
            return $event;
        }

        \Locale::setDefault($newLocale);
        /** @var Translator $translator */
        $translator = $this->mvcTranslator->getTranslator();
        $translator->setLocale($newLocale);
        AbstractValidator::setDefaultTranslator($this->mvcTranslator);

        return $event;
    }

}