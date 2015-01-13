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

namespace ApplicationLibraryTest\Logger\SLFactory;

use ApplicationLibrary\Logger\SLFactory\LoggerSLFactory;
use Test\Bootstrap;
use Zend\Log\LoggerInterface;

class IdentityViewHelperSLFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var LoggerSLFactory
     */
    private $testedObj;

    public function setUp()
    {
        $this->testedObj = new LoggerSLFactory();
    }

    public function testCreateService()
    {
        $result = $this->testedObj->createService(Bootstrap::getServiceManager());

        $this->assertInstanceOf(LoggerInterface::class, $result);
    }
}