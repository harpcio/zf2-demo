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

namespace Application\Listener\Log;

use Zend\EventManager\SharedEventManagerInterface;
use Zend\EventManager\SharedListenerAggregateInterface;
use Zend\Log\LoggerInterface;
use Zend\Mvc\Application;
use Zend\Mvc\MvcEvent;

class LogExceptionListener implements SharedListenerAggregateInterface
{
    /**
     * @var LoggerInterface
     */
    private $logger;

    private $listeners = array();

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function execute(MvcEvent $e)
    {
        if (($exception = $e->getParam('exception'))) {
            $this->logger->crit($exception);
        }
    }

    /**
     * @inheritdoc
     */
    public function attachShared(SharedEventManagerInterface $events)
    {
        $this->listeners[] = $events->attach(
            Application::class,
            MvcEvent::EVENT_DISPATCH_ERROR,
            array($this, 'execute'),
            0
        );
    }

    /**
     * @inheritdoc
     */
    public function detachShared(SharedEventManagerInterface $events)
    {
        foreach ($this->listeners as $index => $listener) {
            if ($events->detach(Application::class, $listener)) {
                unset($this->listeners[$index]);
            }
        }
    }
}