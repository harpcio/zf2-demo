<?php

namespace ApplicationTest\Library\QueryFilter;

use Application\Library\QueryFilter\Condition;
use Application\Library\QueryFilter\Exception\UnsupportedTypeException;

class ConditionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Condition
     */
    private $testedObject;

    /**
     * @dataProvider dataProviderForTestConstructorWithValidArguments
     *
     * @param string $type
     * @param mixed  $data
     */
    public function testConstructorWithValidArguments($type, $data)
    {
        $this->testedObject = new Condition($type, $data);

        $this->assertInstanceOf(Condition::class, $this->testedObject);
        $this->assertSame($type, $this->testedObject->getType());
        $this->assertSame($data, $this->testedObject->getData());
    }

    public function dataProviderForTestConstructorWithValidArguments()
    {
        return [
            [Condition::TYPE_BETWEEN, [mt_rand(1, 100), mt_rand(1, 100)]],
            [Condition::TYPE_MIN, mt_rand(1, 100)],
            [Condition::TYPE_MAX, mt_rand(1, 100)],
            [Condition::TYPE_STARTS_WITH, uniqid('startsWith')],
            [Condition::TYPE_ENDS_WITH, uniqid('endsWith')]
        ];
    }

    public function testConstructorWithInvalidType()
    {
        $type = 'invalid';
        $this->setExpectedException(UnsupportedTypeException::class, sprintf('Unsupported type: %s', $type));

        $this->testedObject = new Condition($type, 'data');
    }
}