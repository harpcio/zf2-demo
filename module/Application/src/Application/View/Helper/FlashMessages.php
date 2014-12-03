<?php

namespace Application\View\Helper;

use Zend\View\Helper\AbstractHelper;
use Zend\Mvc\Controller\Plugin\FlashMessenger;

class FlashMessages extends AbstractHelper
{
    /**
     * @var FlashMessenger
     */
    protected $flashMessenger;

    public function __construct(FlashMessenger $flashMessenger)
    {
        $this->flashMessenger = $flashMessenger;
    }

    public function __invoke($includeCurrentMessages = false)
    {
        $messages = array(
            FlashMessenger::NAMESPACE_ERROR => [],
            FlashMessenger::NAMESPACE_SUCCESS => [],
            FlashMessenger::NAMESPACE_INFO => [],
            FlashMessenger::NAMESPACE_WARNING => [],
            FlashMessenger::NAMESPACE_DEFAULT => []
        );

        foreach ($messages as $namespace => &$message) {
            $message = $this->flashMessenger->getMessagesFromNamespace($namespace);
            if ($includeCurrentMessages) {
                $message = array_merge($message, $this->flashMessenger->getCurrentMessagesFromNamespace($namespace));
                $this->flashMessenger->clearCurrentMessagesFromNamespace($namespace);
            }
        }

        return $messages;
    }
}