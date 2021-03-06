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

namespace ApplicationLibraryTest\Pagination\SLFactory;

use ApplicationLibrary\Pagination\SLFactory\PaginatorInfoFactorySLFactory;
use BusinessLogicLibrary\Pagination\PaginatorInfoFactory;
use Test\Bootstrap;

class PaginatorInfoFactorySLFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var PaginatorInfoFactorySLFactory
     */
    private $testedObj;

    public function setUp()
    {
        $this->testedObj = new PaginatorInfoFactorySLFactory();
    }

    public function testCreateService()
    {
        $result = $this->testedObj->createService(Bootstrap::getServiceManager());

        $this->assertInstanceOf(PaginatorInfoFactory::class, $result);
    }
}