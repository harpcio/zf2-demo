<?php

namespace AuthTest\Form;

use Auth\Form\LoginFormInputFilter;
use Zend\Filter;
use Zend\InputFilter\InputFilter;
use Zend\Validator;

class LoginFormInputFilterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var LoginFormInputFilter
     */
    private $testedObj;

    public function setUp()
    {
        $this->testedObj = new LoginFormInputFilter();
    }

    public function testConstructor()
    {
        $this->assertInstanceOf(InputFilter::class, $this->testedObj);
    }

    public function testParametersOfLoginElement()
    {
        $loginInput = $this->testedObj->get('login');
        $this->assertTrue($loginInput->isRequired());

        /** @var Filter\FilterChain $filterChain */
        $filterChain = $loginInput->getFilterChain();
        $filters = $filterChain->getFilters()->toArray();
        $this->assertInstanceOf(Filter\StripTags::class, $filters[0]);
        $this->assertInstanceOf(Filter\StringTrim::class, $filters[1]);

        /** @var Validator\ValidatorChain $validatorChain */
        $validatorChain = $loginInput->getValidatorChain();
        $validators = $validatorChain->getValidators();

        /** @var \Zend\Validator\StringLength $firstValidator */
        $firstValidator = $validators[0]['instance'];
        $this->assertInstanceOf(Validator\StringLength::class, $firstValidator);
        $this->assertEquals($firstValidator->getMin(), 2);
        $this->assertEquals($firstValidator->getMax(), 255);
        $this->assertEquals($firstValidator->getOption('encoding'), 'UTF-8');
    }

    /**
     * @dataProvider dataProviderForTestLoginElementByValue
     *
     * @param array $value
     * @param bool  $expectedResult
     */
    public function testLoginElementByValue($value, $expectedResult)
    {
        $input = $this->testedObj->get('login');
        $input->setValue($value);
        $result = $input->isValid();

        $this->assertSame($expectedResult, $result);
    }

    public function dataProviderForTestLoginElementByValue()
    {
        return [
            'Empty string should be invalid' => ['', false],
            'String with 1 chars should be invalid' => ['a', false],
            'String with 2 chars should be valid' => ['ab', true],
            'String with 255 chars should be valid' => [str_repeat('a', 255), true],
            'String with 256 chars should be invalid' => [str_repeat('a', 256), false],
        ];
    }

    public function testParametersOfPasswordElement()
    {
        $passwordInput = $this->testedObj->get('password');
        $this->assertTrue($passwordInput->isRequired());

        /** @var Filter\FilterChain $filterChain */
        $filterChain = $passwordInput->getFilterChain();
        $filters = $filterChain->getFilters()->toArray();
        $this->assertInstanceOf(Filter\StripTags::class, $filters[0]);
        $this->assertInstanceOf(Filter\StringTrim::class, $filters[1]);

        /** @var Validator\ValidatorChain $validatorChain */
        $validatorChain = $passwordInput->getValidatorChain();
        $validators = $validatorChain->getValidators();

        /** @var \Zend\Validator\StringLength $firstValidator */
        $firstValidator = $validators[0]['instance'];
        $this->assertInstanceOf(Validator\StringLength::class, $firstValidator);
        $this->assertEquals($firstValidator->getMin(), 5);
        $this->assertEquals($firstValidator->getMax(), 255);
        $this->assertEquals($firstValidator->getOption('encoding'), 'UTF-8');
    }

    /**
     * @dataProvider dataProviderForTestPasswordElementByValue
     *
     * @param array $value
     * @param bool  $expectedResult
     */
    public function testPasswordElementByValue($value, $expectedResult)
    {
        $input = $this->testedObj->get('password');
        $input->setValue($value);
        $result = $input->isValid();

        $this->assertSame($expectedResult, $result);
    }

    public function dataProviderForTestPasswordElementByValue()
    {
        return [
            'Empty string should be invalid' => ['', false],
            'String with 2 chars should be invalid' => ['ab', false],
            'String with 5 chars should be invalid' => ['abcde', true],
            'String with 255 chars should be valid' => [str_repeat('a', 255), true],
            'String with 256 chars should be invalid' => [str_repeat('a', 256), false],
        ];
    }
}