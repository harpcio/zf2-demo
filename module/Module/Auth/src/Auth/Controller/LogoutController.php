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

namespace Module\Auth\Controller;

use Module\Auth\Service\LogoutService;
use Zend\Mvc\Controller\AbstractActionController;

class LogoutController extends AbstractActionController
{
    /**
     * @var LogoutService
     */
    private $service;

    public function __construct(LogoutService $service)
    {
        $this->service = $service;
    }

    public function indexAction()
    {
        try {
            $this->service->logout();

            return $this->redirect()->toRoute('home');
        } catch (\Exception $e) {
            return $this->flashMessenger()->addErrorMessage(
                'An unexpected error has occurred, please contact your system administrator'
            );
        }
    }
}