<?php

namespace LibraryTest\Form;

use Library\Form\Book\CreateFormInputFilter;
use Zend\Filter\Digits;
use Zend\Filter\FilterChain;
use Zend\Filter\StringTrim;
use Zend\Filter\StripTags;
use Zend\InputFilter\InputFilter;
use Zend\Validator\GreaterThan;
use Zend\Validator\Isbn;
use Zend\Validator\LessThan;
use Zend\Validator\Regex;
use Zend\Validator\StringLength;
use Zend\Validator\ValidatorChain;

class CreateFormInputFilterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var CreateFormInputFilter
     */
    private $testedObj;

    public function setUp()
    {
        $this->testedObj = new CreateFormInputFilter();
    }

    public function testConstructor()
    {
        $this->assertInstanceOf(InputFilter::class, $this->testedObj);
    }

    public function testParametersOfTitleElement()
    {
        $input = $this->testedObj->get('title');
        $this->assertTrue($input->isRequired());

        /** @var FilterChain $filterChain */
        $filterChain = $input->getFilterChain();
        $filters = $filterChain->getFilters()->toArray();
        $this->assertInstanceOf(StripTags::class, $filters[0]);
        $this->assertInstanceOf(StringTrim::class, $filters[1]);

        /** @var ValidatorChain $validatorChain */
        $validatorChain = $input->getValidatorChain();
        $validators = $validatorChain->getValidators();

        /** @var \Zend\Validator\StringLength $firstValidator */
        $firstValidator = $validators[0]['instance'];
        $this->assertInstanceOf(StringLength::class, $firstValidator);
        $this->assertEquals($firstValidator->getMin(), 3);
        $this->assertEquals($firstValidator->getMax(), 255);
        $this->assertEquals($firstValidator->getOption('encoding'), 'UTF-8');
    }

    /**
     * @dataProvider dataProviderForTestTitleElementByValue
     *
     * @param array $value
     * @param bool  $expectedResult
     */
    public function testTitleElementByValue($value, $expectedResult)
    {
        $input = $this->testedObj->get('title');
        $input->setValue($value);
        $result = $input->isValid();

        $this->assertSame($expectedResult, $result);
    }

    public function dataProviderForTestTitleElementByValue()
    {
        return [
            'Empty string should be invalid' => ['', false],
            'String with 2 chars should be invalid' => ['ab', false],
            'String with 3 chars should be valid' => ['abc', true],
            'String with 255 chars should be valid' => [str_repeat('a', 255), true],
            'String with 256 chars should be invalid' => [str_repeat('a', 256), false],
        ];
    }

    public function testParametersOfDescriptionElement()
    {
        $input = $this->testedObj->get('description');
        $this->assertFalse($input->isRequired());

        /** @var FilterChain $filterChain */
        $filterChain = $input->getFilterChain();
        $filters = $filterChain->getFilters()->toArray();
        $this->assertInstanceOf(StripTags::class, $filters[0]);
        $this->assertInstanceOf(StringTrim::class, $filters[1]);
    }

    /**
     * @dataProvider dataProviderForTestDescriptionElementByValue
     *
     * @param array $value
     * @param bool  $expectedResult
     */
    public function testDescriptionElementByValue($value, $expectedResult)
    {
        $input = $this->testedObj->get('description');
        $input->setValue($value);
        $result = $input->isValid();

        $this->assertSame($expectedResult, $result);
    }

    public function dataProviderForTestDescriptionElementByValue()
    {
        return [
            'Empty string should be valid' => ['', true],
            'String with 256 chars should be valid' => [str_repeat('a', 256), true],
        ];
    }

    public function testParametersOfIsbnElement()
    {
        $input = $this->testedObj->get('isbn');
        $this->assertTrue($input->isRequired());

        /** @var FilterChain $filterChain */
        $filterChain = $input->getFilterChain();
        $filters = $filterChain->getFilters()->toArray();
        $this->assertInstanceOf(StripTags::class, $filters[0]);
        $this->assertInstanceOf(StringTrim::class, $filters[1]);

        /** @var ValidatorChain $validatorChain */
        $validatorChain = $input->getValidatorChain();
        $validators = $validatorChain->getValidators();

        /** @var \Zend\Validator\Isbn $firstValidator */
        $firstValidator = $validators[0]['instance'];
        $this->assertInstanceOf(Isbn::class, $firstValidator);
        $this->assertEquals($firstValidator->getSeparator(), '-');
    }

    /**
     * @dataProvider dataProviderForTestIsbnElementByValue
     *
     * @param array $value
     * @param bool  $expectedResult
     */
    public function testIsbnElementByValue($value, $expectedResult)
    {
        $input = $this->testedObj->get('isbn');
        $input->setValue($value);
        $result = $input->isValid();

        $this->assertSame($expectedResult, $result);
    }

    public function dataProviderForTestIsbnElementByValue()
    {
        return [
            'Empty string should be invalid' => ['', false],
            'String with valid isbn should be valid' => ['978-17-832-8719-2', true],
            'String with invalid isbn should be invalid' => ['078-17-832-8719-2', false],
            'String with (14 numbers) invalid isbn should be invalid' => ['978-17-832-8719-20', false],
        ];
    }

    public function testParametersOfYearElement()
    {
        $input = $this->testedObj->get('year');
        $this->assertTrue($input->isRequired());

        /** @var FilterChain $filterChain */
        $filterChain = $input->getFilterChain();
        $filters = $filterChain->getFilters()->toArray();
        $this->assertInstanceOf(Digits::class, $filters[0]);
        $this->assertInstanceOf(StringTrim::class, $filters[1]);

        /** @var ValidatorChain $validatorChain */
        $validatorChain = $input->getValidatorChain();
        $validators = $validatorChain->getValidators();

        /** @var \Zend\Validator\GreaterThan $firstValidator */
        $firstValidator = $validators[0]['instance'];
        $this->assertInstanceOf(GreaterThan::class, $firstValidator);
        $this->assertEquals($firstValidator->getMin(), '1900');
        $this->assertEquals($firstValidator->getInclusive(), true);
        $this->assertEquals($firstValidator->getOption('encoding'), 'UTF-8');

        /** @var \Zend\Validator\LessThan $secondValidator */
        $secondValidator = $validators[1]['instance'];
        $this->assertInstanceOf(LessThan::class, $secondValidator);
        $this->assertEquals($secondValidator->getInclusive(), true);
        $this->assertEquals($secondValidator->getMax(), date('Y'));
        $this->assertEquals($secondValidator->getOption('encoding'), 'UTF-8');
    }

    /**
     * @dataProvider dataProviderForTestYearElementByValue
     *
     * @param array $value
     * @param bool  $expectedResult
     */
    public function testYearElementByValue($value, $expectedResult)
    {
        $input = $this->testedObj->get('year');
        $input->setValue($value);
        $result = $input->isValid();

        $this->assertSame($expectedResult, $result);
    }

    public function dataProviderForTestYearElementByValue()
    {
        return [
            'Empty string should be invalid' => ['', false],
            'String with min year minus one should be invalid' => ['1899', false],
            'String with min year should be valid' => ['1900', true],
            'String with max year should be valid' => [date('Y'), true],
            'String with max year plus one should be invalid' => [date('Y') + 1, false],
        ];
    }

    public function testParametersOfPublisherElement()
    {
        $input = $this->testedObj->get('publisher');
        $this->assertTrue($input->isRequired());

        /** @var FilterChain $filterChain */
        $filterChain = $input->getFilterChain();
        $filters = $filterChain->getFilters()->toArray();
        $this->assertInstanceOf(StripTags::class, $filters[0]);
        $this->assertInstanceOf(StringTrim::class, $filters[1]);

        /** @var ValidatorChain $validatorChain */
        $validatorChain = $input->getValidatorChain();
        $validators = $validatorChain->getValidators();

        /** @var \Zend\Validator\StringLength $firstValidator */
        $firstValidator = $validators[0]['instance'];
        $this->assertInstanceOf(StringLength::class, $firstValidator);
        $this->assertEquals($firstValidator->getMin(), 3);
        $this->assertEquals($firstValidator->getMax(), 255);
        $this->assertEquals($firstValidator->getOption('encoding'), 'UTF-8');
    }

    /**
     * @dataProvider dataProviderForTestPublisherElementByValue
     *
     * @param array $value
     * @param bool  $expectedResult
     */
    public function testPublisherElementByValue($value, $expectedResult)
    {
        $input = $this->testedObj->get('publisher');
        $input->setValue($value);
        $result = $input->isValid();

        $this->assertSame($expectedResult, $result);
    }

    public function dataProviderForTestPublisherElementByValue()
    {
        return [
            'Empty string should be invalid' => ['', false],
            'String with 2 chars should be invalid' => ['ab', false],
            'String with 3 chars should be valid' => ['abc', true],
            'String with 255 chars should be valid' => [str_repeat('a', 255), true],
            'String with 256 chars should be invalid' => [str_repeat('a', 256), false],
        ];
    }

    public function testParametersOfPriceElement()
    {
        $input = $this->testedObj->get('price');
        $this->assertFalse($input->isRequired());

        /** @var FilterChain $filterChain */
        $filterChain = $input->getFilterChain();
        $filters = $filterChain->getFilters()->toArray();
        $this->assertInstanceOf(StringTrim::class, $filters[0]);

        /** @var ValidatorChain $validatorChain */
        $validatorChain = $input->getValidatorChain();
        $validators = $validatorChain->getValidators();

        /** @var \Zend\Validator\Regex $firstValidator */
        $firstValidator = $validators[0]['instance'];
        $this->assertInstanceOf(Regex::class, $firstValidator);
        $this->assertEquals($firstValidator->getPattern(), '/^[0-9]+([\.|,]{1}[0-9]*)?$/');
    }

    /**
     * @dataProvider dataProviderForTestPriceElementByValue
     *
     * @param array $value
     * @param bool  $expectedResult
     */
    public function testPriceElementByValue($value, $expectedResult)
    {
        $input = $this->testedObj->get('price');
        $input->setValue($value);
        $result = $input->isValid();

        $this->assertSame($expectedResult, $result);
    }

    public function dataProviderForTestPriceElementByValue()
    {
        return [
            'Empty string should be invalid' => ['', false],
            'Float as string should be valid' => ['34.23', true],
            'Float should be valid' => [23.92, true],
            'Zero as string should be valid' => ['0', true],
            'Zero integer should be valid' => [(int)0, true],
            'Zero float as string should be valid' => ['0.0', true],
            'Zero float should be valid' => [(float)0, true],
            'Float as string with comma should be valid' => ['12,92', true],
            'Numeric string with two comma should be invalid' => ['12,51,54', false],
            'Numeric string with dot and comma should be invalid' => ['12.51,54', false],
            'Numeric string with comma and dot should be invalid' => ['12,51.54', false],
            'Alphanumeric string with comma should be invalid' => ['abc23,123', false],
            'Alphanumeric string with dot should be invalid' => ['23.123abc', false]
        ];
    }
}