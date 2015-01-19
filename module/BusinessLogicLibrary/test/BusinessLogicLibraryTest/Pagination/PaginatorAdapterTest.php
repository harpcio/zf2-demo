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

namespace BusinessLogicLibraryTest\Pagination;

use BusinessLogicLibrary\Pagination\PaginatorAdapter;

class PaginatorAdapterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var PaginatorAdapter
     */
    private $testedObject;

    public function setUp()
    {
        $this->testedObject = new PaginatorAdapter(new Provider\SimplePaginator());
    }

    public function testCount()
    {
        $result = $this->testedObject->count();

        $this->assertSame(77, $result);
    }

    public function testGetIterator()
    {
        $result = $this->testedObject->getIterator();

        $this->assertInstanceOf('Traversable', $result);
    }

    public function testConstructorWithOnlyCountableObject()
    {
        $this->setExpectedException('InvalidArgumentException', 'Paginator adapter must be instanceof Countable and IteratorAggregate');

        new PaginatorAdapter(new Provider\SimplePaginatorOnlyCountable());
    }

    public function testConstructorWithOnlyIteratorAggregate()
    {
        $this->setExpectedException('InvalidArgumentException', 'Paginator adapter must be instanceof Countable and IteratorAggregate');

        new PaginatorAdapter(new Provider\SimplePaginatorOnlyIteratorAggregate());
    }
}