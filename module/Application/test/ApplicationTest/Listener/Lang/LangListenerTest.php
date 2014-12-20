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

namespace ApplicationTest\Listener\Lang;

use Application\Listener\Lang\LangListener;
use Application\Listener\Lang\LangRecognizer;
use Application\Listener\Lang\LangRedirector;
use PHPUnit_Framework_MockObject_MockObject as MockObject;
use Zend\Mvc\I18n\Translator;
use Zend\Mvc\MvcEvent;
use Zend\Mvc\Router\SimpleRouteStack;
use Zend\Validator\AbstractValidator;

class LangListenerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var LangListener
     */
    private $testedObject;

    /**
     * @var string
     */
    private $defaultLocale;

    /**
     * @var MockObject
     */
    private $mvcTranslatorMock;

    /**
     * @var MockObject
     */
    private $routeMock;

    /**
     * @var MockObject
     */
    private $langRecognizerMock;

    /**
     * @var MockObject
     */
    private $langRedirectorMock;

    public function setUp()
    {
        $this->defaultLocale = \Locale::getDefault();

        $this->prepareMocks();

        $this->testedObject = new LangListener(
            $this->mvcTranslatorMock,
            $this->langRecognizerMock,
            $this->langRedirectorMock
        );
    }

    public function tearDown()
    {
        \Locale::setDefault($this->defaultLocale);
        AbstractValidator::setDefaultTranslator(null);
    }

    private function prepareMocks()
    {
        $this->mvcTranslatorMock = $this->getMockBuilder(Translator::class)
            ->setMethods(['getTranslator', 'setLocale'])
            ->disableOriginalConstructor()
            ->getMock();

        $this->routeMock = $this->getMockBuilder(SimpleRouteStack::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->langRecognizerMock = $this->getMockBuilder(LangRecognizer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->langRedirectorMock = $this->getMockBuilder(LangRedirector::class)
            ->disableOriginalConstructor()
            ->getMock();
    }

    public function testInvoke_WhenRecognizerDoNotRecognizedLanguage()
    {
        $event = new MvcEvent();

        $this->langRecognizerMock->expects($this->once())
            ->method('recognize')
            ->with($event)
            ->willReturn(false);

        $result = $this->testedObject->__invoke($event);

        $this->assertFalse($result);
    }

    public function testInvoke_WhenShouldBeRedirection()
    {
        \Locale::setDefault('en_GB');

        $event = new MvcEvent();

        $this->langRecognizerMock->expects($this->once())
            ->method('recognize')
            ->with($event)
            ->willReturn(['pl', 'pl_PL', null]);

        $this->langRedirectorMock->expects($this->once())
            ->method('checkRedirect')
            ->with($event, 'pl', null)
            ->willReturn(true);

        $result = $this->testedObject->__invoke($event);

        $this->assertSame($event, $result);
        $this->assertSame('en_GB', \Locale::getDefault());
    }

    public function testInvoke_WhenThereIsNoRedirection()
    {
        $event = new MvcEvent();

        $this->langRecognizerMock->expects($this->once())
            ->method('recognize')
            ->with($event)
            ->willReturn(['pl', 'pl_PL', null]);

        $this->langRedirectorMock->expects($this->once())
            ->method('checkRedirect')
            ->with($event, 'pl', null)
            ->willReturn(false);

        $this->mvcTranslatorMock->expects($this->once())
            ->method('getTranslator')
            ->willReturnSelf();

        $this->mvcTranslatorMock->expects($this->once())
            ->method('setLocale')
            ->with('pl_PL');

        $result = $this->testedObject->__invoke($event);

        $this->assertSame($event, $result);
        $this->assertSame('pl_PL', \Locale::getDefault());
    }
}