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