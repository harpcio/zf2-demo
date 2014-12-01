<?php

namespace Acl\View\Helper;

use BusinessLogic\Users\Entity\UserEntity;
use Zend\Permissions\Acl\Acl;
use Zend\View\Helper\AbstractHelper;
use Zend\View\Renderer\PhpRenderer;

class IsAllowed extends AbstractHelper
{
    public function __invoke($resource, $privilege)
    {
        /** @var PhpRenderer $view */
        $view = $this->getView();
        /** @var UserEntity $user */
        $user = $view->identity();
        /** @var Acl $acl */
        $acl = $view->viewModel()->getRoot()->getVariable('acl');

        if ($acl && $user && $acl->isAllowed($user->getRole(), strtolower($resource), strtolower($privilege))) {
            return true;
        }

        return false;
    }
}