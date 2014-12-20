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

namespace ApplicationTest\Listener\Log\SLFactory;

use Application\Listener\Log\LogExceptionListener;
use Application\Listener\Log\SLFactory\LogExceptionListenerSLFactory;
use Test\Bootstrap;

class LogExceptionListenerSLFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var LogExceptionListenerSLFactory
     */
    private $testedObj;

    public function setUp()
    {
        $this->testedObj = new LogExceptionListenerSLFactory();
    }

    public function testCreateService()
    {
        $result = $this->testedObj->createService(Bootstrap::getServiceManager());

        $this->assertInstanceOf(LogExceptionListener::class, $result);
    }
}