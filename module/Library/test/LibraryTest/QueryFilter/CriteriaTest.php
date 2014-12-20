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

namespace LibraryTest\QueryFilter;

use Library\QueryFilter\Criteria;
use Library\QueryFilter\Exception\UnsupportedTypeException;

class CriteriaTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Criteria
     */
    private $testedObject;

    /**
     * @dataProvider dataProviderForTestConstructorWithValidArguments
     *
     * @param string $type
     * @param string $key
     * @param mixed  $data
     */
    public function testConstructorWithValidArguments($type, $key, $data)
    {
        $this->testedObject = new Criteria($type, $key, $data);

        $this->assertInstanceOf(Criteria::class, $this->testedObject);
        $this->assertSame($type, $this->testedObject->getType());
        $this->assertSame($key, $this->testedObject->getKey());
        $this->assertSame($data, $this->testedObject->getValue());
    }

    public function dataProviderForTestConstructorWithValidArguments()
    {
        return [
            [Criteria::TYPE_CONDITION_BETWEEN, uniqid('key'), [mt_rand(1, 100), mt_rand(1, 100)]],
            [Criteria::TYPE_CONDITION_MIN, uniqid('key'), mt_rand(1, 100)],
            [Criteria::TYPE_CONDITION_MAX, uniqid('key'), mt_rand(1, 100)],
            [Criteria::TYPE_CONDITION_STARTS_WITH, uniqid('key'), uniqid('startsWith')],
            [Criteria::TYPE_CONDITION_ENDS_WITH, uniqid('key'), uniqid('endsWith')]
        ];
    }

    public function testConstructorWithInvalidType()
    {
        $type = 'invalid';
        $this->setExpectedException(UnsupportedTypeException::class, sprintf('Unsupported type: %s', $type));

        $this->testedObject = new Criteria($type, 'key', 'data');
    }
}