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

namespace ApplicationCoreAuth\Controller;

use Zend\Mvc\Controller\AbstractActionController;

class NoAccessController extends AbstractActionController
{
    public function indexAction()
    {
        return [];
    }
}