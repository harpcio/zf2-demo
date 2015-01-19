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

namespace ApplicationDataAccessDoctrineORMLibraryTest\QueryFilter\Command\Repository\SLFactory;

use ApplicationDataAccessDoctrineORMLibrary\QueryFilter\Command\Repository\SLFactory\CommandCollectionSLFactory;
use BusinessLogicLibrary\QueryFilter\Command\Repository\CommandCollection;
use Test\Bootstrap;

class CommandCollectionSLFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var CommandCollectionSLFactory
     */
    private $testedObj;

    public function setUp()
    {
        $this->testedObj = new CommandCollectionSLFactory();
    }

    public function testCreateService()
    {
        $result = $this->testedObj->createService(Bootstrap::getServiceManager());

        $this->assertInstanceOf(CommandCollection::class, $result);
    }
}