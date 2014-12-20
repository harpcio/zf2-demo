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
        if (($exception = $event->getParam('exception'))) {
            if (!($exception instanceof AbstractException) || DEVELOPMENT_ENV) {
                $this->logger->crit($exception);
            }
        }
    }
}