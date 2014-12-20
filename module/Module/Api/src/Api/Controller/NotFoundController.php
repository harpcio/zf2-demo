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

namespace Module\Api\Controller;

use Module\Api\Exception;
use Zend\Mvc\Controller\AbstractRestfulController;

class NotFoundController extends AbstractRestfulController
{
    public function notFoundAction()
    {
        throw new Exception\NotFoundException();
    }
}