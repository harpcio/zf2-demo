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

namespace ApplicationCoreAcl\Service\Listener;

use ApplicationCoreAcl\Service\AclService;
use Zend\EventManager\SharedEventManagerInterface;
use Zend\EventManager\SharedListenerAggregateInterface;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Mvc\MvcEvent;

class CheckAccessListener implements SharedListenerAggregateInterface
{
    /**
     * @var AclService
     */
    private $checkAclService;

    private $listeners = array();

    public function __construct(AclService $checkAclService)
    {
        $this->checkAclService = $checkAclService;
    }

    public function onDispatch(MvcEvent $e)
    {
        $this->checkAclService->checkAccess($e);
    }

    /**
     * @inheritdoc
     */
    public function attachShared(SharedEventManagerInterface $events)
    {
        $this->listeners[] = $events->attach(
            AbstractActionController::class,
            MvcEvent::EVENT_DISPATCH,
            array($this, 'onDispatch'),
            2
        );
    }

    /**
     * @inheritdoc
     */
    public function detachShared(SharedEventManagerInterface $events)
    {
        foreach ($this->listeners as $index => $listener) {
            if ($events->detach(AbstractActionController::class, $listener)) {
                unset($this->listeners[$index]);
            }
        }
    }
}