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

namespace ApplicationCoreLangTest\Listener\Lang\SLFactory;

use ApplicationCoreLang\Listener\Lang\LangRecognizer;
use ApplicationCoreLang\Listener\Lang\SLFactory\LangRecognizerSLFactory;
use Test\Bootstrap;

class LangRecognizerSLFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var LangRecognizerSLFactory
     */
    private $testedObj;

    public function setUp()
    {
        $this->testedObj = new LangRecognizerSLFactory();
    }

    public function testCreateService()
    {
        $result = $this->testedObj->createService(Bootstrap::getServiceManager());

        $this->assertInstanceOf(LangRecognizer::class, $result);
    }
}