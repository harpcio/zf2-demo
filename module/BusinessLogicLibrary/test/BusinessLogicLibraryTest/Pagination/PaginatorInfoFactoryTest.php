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

use BusinessLogicLibrary\Pagination\PaginatorInfo;
use BusinessLogicLibrary\Pagination\PaginatorInfoFactory;

class PaginatorInfoFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var PaginatorInfoFactory
     */
    private $testedObject;

    /**
     * @var int
     */
    private $itemsPerPage;

    public function setUp()
    {
        $this->itemsPerPage = 10;

        $config = [
            'itemsPerPage' => $this->itemsPerPage
        ];

        $this->testedObject = new PaginatorInfoFactory($config);
    }

    public function testCreate_WithoutPrepareFilterParamsFirst()
    {
        $this->setExpectedException(
            'BusinessLogicLibrary\Pagination\Exception\InvalidArgumentException',
            'Filter params not prepared'
        );

        $this->testedObject->create(100);
    }

    public function testPrepareFilterParams_WithEmptyFilterParams()
    {
        $filterParams = [];

        $result = $this->testedObject->prepareFilterParams($filterParams);

        $expected = [
            '$page' => 1,
            '$limit' => $this->itemsPerPage
        ];

        $this->assertSame($expected, $result);
    }

    public function testPrepareFilterParams()
    {
        $filterParams = [
            '$page' => 3,
            '$limit' => 1
        ];

        $result = $this->testedObject->prepareFilterParams($filterParams);

        $this->assertSame($filterParams, $result);
    }

    public function testCreate()
    {
        $filterParams = [
            '$page' => 2,
            '$limit' => 5
        ];

        $numberOfItems = mt_rand(100, 1000);

        $this->testedObject->prepareFilterParams($filterParams);
        $result = $this->testedObject->create($numberOfItems);

        $this->assertInstanceOf(PaginatorInfo::class, $result);
        $this->assertSame($numberOfItems, $result->getNumberOfItems());
    }
}