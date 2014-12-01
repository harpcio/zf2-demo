<?php

namespace Module\LibraryBooksTest\Form;

use Module\LibraryBooks\Form\DeleteForm;
use Zend\Form\Element\Csrf;
use Zend\Form\Element\Hidden;
use Zend\Form\Element\Submit;
use Zend\Form\Form;

class DeleteFormTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var DeleteForm
     */
    private $testedObj;

    public function setUp()
    {
        $this->testedObj = new DeleteForm();
    }

    public function testConstructor()
    {
        $this->assertInstanceOf(Form::class, $this->testedObj);
        $this->assertEquals($this->testedObj->count(), 3);

        $this->assertTrue($this->testedObj->has('id'));
        $this->assertTrue($this->testedObj->has('csrf'));
        $this->assertTrue($this->testedObj->has('submit'));

        $idInput = $this->testedObj->get('id');
        $this->assertInstanceOf(Hidden::class, $idInput);

        $csrfInput = $this->testedObj->get('csrf');
        $this->assertInstanceOf(Csrf::class, $csrfInput);

        $submitInput = $this->testedObj->get('submit');
        $this->assertInstanceOf(Submit::class, $submitInput);
        $this->assertEquals('Delete', $submitInput->getValue());
    }
}