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

namespace Module\ApiV1LibraryBooks\Controller;

use Module\Api\Controller\AbstractRestfulJsonController;

class BooksController extends AbstractRestfulJsonController
{
    public function getCollectionOptions()
    {
        return ['GET', 'POST', 'OPTIONS'];
    }

    public function getResourceOptions()
    {
        return ['GET', 'PUT', 'DELETE', 'OPTIONS'];
    }

}