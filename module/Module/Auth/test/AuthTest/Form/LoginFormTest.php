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

namespace Module\AuthTest\Form;

use Module\Auth\Form\LoginForm;
use Zend\Form\Element;
use Zend\Form\Form;

class LoginFormTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var LoginForm
     */
    private $testedObj;

    public function setUp()
    {
        $this->testedObj = new LoginForm();
    }

    public function testConstructor()
    {
        $this->assertInstanceOf(Form::class, $this->testedObj);
        $this->assertEquals($this->testedObj->count(), 4);

        $this->assertTrue($this->testedObj->has('login'));
        $this->assertTrue($this->testedObj->has('password'));
        $this->assertTrue($this->testedObj->has('csrf'));
        $this->assertTrue($this->testedObj->has('submit'));

        $loginInput = $this->testedObj->get('login');
        $this->assertInstanceOf(Element\Text::class, $loginInput);

        $passwordInput = $this->testedObj->get('password');
        $this->assertInstanceOf(Element\Password::class, $passwordInput);

        $csrfInput = $this->testedObj->get('csrf');
        $this->assertInstanceOf(Element\Csrf::class, $csrfInput);

        $submitInput = $this->testedObj->get('submit');
        $this->assertInstanceOf(Element\Submit::class, $submitInput);
        $this->assertEquals('Login', $submitInput->getValue());
    }
}