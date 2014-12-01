<?php

namespace Module\LibraryBooksTest\Form;

use Module\LibraryBooks\Form\CreateForm;
use Zend\Form\Element\Csrf;
use Zend\Form\Element\Submit;
use Zend\Form\Element\Text;
use Zend\Form\Element\Textarea;
use Zend\Form\Form;

class CreateFormTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var CreateForm
     */
    private $testedObj;

    public function setUp()
    {
        $this->testedObj = new CreateForm();
    }

    public function testConstructor()
    {
        $this->assertInstanceOf(Form::class, $this->testedObj);
        $this->assertEquals($this->testedObj->count(), 8);

        $this->assertTrue($this->testedObj->has('title'));
        $this->assertTrue($this->testedObj->has('description'));
        $this->assertTrue($this->testedObj->has('isbn'));
        $this->assertTrue($this->testedObj->has('year'));
        $this->assertTrue($this->testedObj->has('publisher'));
        $this->assertTrue($this->testedObj->has('price'));
        $this->assertTrue($this->testedObj->has('csrf'));
        $this->assertTrue($this->testedObj->has('submit'));
    }

    public function testTitleElement()
    {
        $titleInput = $this->testedObj->get('title');
        $this->assertInstanceOf(Text::class, $titleInput);
    }

    public function testDescriptionElement()
    {
        $descriptionInput = $this->testedObj->get('description');
        $this->assertInstanceOf(Textarea::class, $descriptionInput);
    }

    public function testIsbnElement()
    {
        $isbnInput = $this->testedObj->get('isbn');
        $this->assertInstanceOf(Text::class, $isbnInput);
    }

    public function testYearElement()
    {
        $yearInput = $this->testedObj->get('year');
        $this->assertInstanceOf(Text::class, $yearInput);
    }

    public function testPublisherElement()
    {
        $publisherInput = $this->testedObj->get('publisher');
        $this->assertInstanceOf(Text::class, $publisherInput);
    }

    public function testPriceElement()
    {
        $priceInput = $this->testedObj->get('price');
        $this->assertInstanceOf(Text::class, $priceInput);
    }

    public function testCsrfElement()
    {
        $csrfInput = $this->testedObj->get('csrf');
        $this->assertInstanceOf(Csrf::class, $csrfInput);
    }

    public function testSubmitElement()
    {
        $submitInput = $this->testedObj->get('submit');
        $this->assertInstanceOf(Submit::class, $submitInput);
    }
}