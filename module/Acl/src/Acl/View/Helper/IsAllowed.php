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

        if ($acl && $user) {
            return $acl->isAllowed(
                strtolower($user->getRole()),
                strtolower($resource),
                strtolower($privilege)
            );
        }

        return false;
    }
}