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

namespace ApplicationFeatureApi\Listener;

use ApplicationCoreAcl\Service\AclService;
use ApplicationFeatureApi\Controller\AbstractApiActionController;
use ApplicationFeatureApi\Exception;
use Zend\EventManager\Event;
use Zend\EventManager\SharedEventManagerInterface;
use Zend\EventManager\SharedListenerAggregateInterface;

class AclIsNotAllowedListener implements SharedListenerAggregateInterface
{

    private $listeners = array();

    public function onIsNotAllowed(Event $e)
    {
        if ($e->getTarget() instanceof AbstractApiActionController) {
            throw new Exception\UnauthorizedException();
        }
    }

    /**
     * @inheritdoc
     */
    public function attachShared(SharedEventManagerInterface $events)
    {
        $this->listeners[] = $events->attach(
            AclService::class,
            AclService::EVENT_IS_NOT_ALLOWED,
            array($this, 'onIsNotAllowed'),
            1
        );
    }

    /**
     * @inheritdoc
     */
    public function detachShared(SharedEventManagerInterface $events)
    {
        foreach ($this->listeners as $index => $listener) {
            if ($events->detach(AclService::class, $listener)) {
                unset($this->listeners[$index]);
            }
        }
    }
}