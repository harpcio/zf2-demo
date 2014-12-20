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

namespace LibraryTest\Collection\Provider;

use Library\Collection\AbstractInterfaceTypeCollection;

class MyClassInterfaceCollection extends AbstractInterfaceTypeCollection
{
    protected $interfaceOrObjectName = MyClassInterface::class;
}