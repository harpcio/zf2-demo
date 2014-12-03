<?php

namespace ApplicationTest\View\Helper;

use Application\View\Helper\FlashMessages;
use Zend\Mvc\Controller\Plugin\FlashMessenger;

class FlashMessagesTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var FlashMessages
     */
    private $testedObject;

    /**
     * @var FlashMessenger
     */
    private $flashMessenger;

    public function setUp()
    {
        $this->flashMessenger = new FlashMessenger();

        $this->testedObject = new FlashMessages($this->flashMessenger);
    }

    public function testInvoke_WithIncludeCurrentMessages()
    {
        $this->flashMessenger->addErrorMessage('ErrorMessage1')
            ->addInfoMessage('InfoMessage2')
            ->addSuccessMessage('SuccessMessage3')
            ->addWarningMessage('WarningMessage4')
            ->addMessage('Message5');

        $result = $this->testedObject->__invoke(true);

        $expected = [
            FlashMessenger::NAMESPACE_ERROR => ['ErrorMessage1'],
            FlashMessenger::NAMESPACE_SUCCESS => ['SuccessMessage3'],
            FlashMessenger::NAMESPACE_INFO => ['InfoMessage2'],
            FlashMessenger::NAMESPACE_WARNING => ['WarningMessage4'],
            FlashMessenger::NAMESPACE_DEFAULT => ['Message5']
        ];

        $this->assertSame($expected, $result);
    }

}