<?php

namespace Application\Service\Listener;

use Module\Api\Exception\AbstractException;
use Zend\Log\LoggerInterface;
use Zend\Mvc\MvcEvent;

class LogExceptionListener
{
    /**
     * @var LoggerInterface
     */
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function __invoke(MvcEvent $event)
    {
        $exception = $event->getParam('exception');

        if ($exception && !($exception instanceof AbstractException)) {
            $this->logger->crit($exception);
        }
    }
}