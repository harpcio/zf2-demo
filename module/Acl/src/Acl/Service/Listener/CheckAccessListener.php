<?php

namespace Acl\Service\Listener;

use Acl\Service\AclService;
use Zend\Mvc\MvcEvent;

class CheckAccessListener
{
    /**
     * @var AclService
     */
    private $checkAclService;

    public function __construct(AclService $checkAclService)
    {
        $this->checkAclService = $checkAclService;
    }

    public function __invoke(MvcEvent $event)
    {
        $this->checkAclService->checkAccess($event);
    }
}