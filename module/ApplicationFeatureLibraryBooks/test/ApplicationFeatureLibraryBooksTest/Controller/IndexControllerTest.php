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

namespace ApplicationFeatureLibraryBooksTest\Controller;

use BusinessLogicLibrary\Pagination\PaginatorAdapter;
use BusinessLogicLibrary\Pagination\PaginatorInfo;
use BusinessLogicLibrary\Pagination\PaginatorInfoFactory;
use BusinessLogicDomainBooksTest\Entity\Provider\BookEntityProvider;
use BusinessLogicLibrary\QueryFilter\Exception\UnrecognizedFieldException;
use BusinessLogicLibrary\QueryFilter\Exception\UnsupportedTypeException;
use BusinessLogicLibrary\QueryFilter\QueryFilter;
use ApplicationLibraryTest\Controller\AbstractControllerTestCase;
use ApplicationFeatureLibraryBooks\Controller\IndexController;
use ApplicationFeatureLibraryBooks\Service\FilterResultsService;
use PHPUnit_Framework_MockObject_MockObject as MockObject;
use Zend\Http\Request;
use Zend\Http\Response;

class IndexControllerTest extends AbstractControllerTestCase
{
    /**
     * @var BookEntityProvider
     */
    private $bookEntityProvider;

    /**
     * @var MockObject|FilterResultsService
     */
    private $filterResultsServiceMock;

    /**
     * @var \BusinessLogicLibrary\QueryFilter\QueryFilter
     */
    private $queryFilter;

    /**
     * @var MockObject|PaginatorInfoFactory
     */
    protected $paginatorInfoFactoryMock;

    /**
     * @var IndexController
     */
    protected $controller;

    public function setUp()
    {
        $this->init('index');

        $this->bookEntityProvider = new BookEntityProvider();

        $this->filterResultsServiceMock = $this->getMockBuilder(FilterResultsService::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->queryFilter = new QueryFilter([], []);

        $this->paginatorInfoFactoryMock = $this->getMockBuilder(PaginatorInfoFactory::class)
            ->setConstructorArgs([['pagination' => ['itemsPerPage' => 10]]])
            ->setMethods(array('create'))
            ->getMock();

        $this->controller = new IndexController(
            $this->filterResultsServiceMock,
            $this->queryFilter,
            $this->paginatorInfoFactoryMock
        );

        $this->controller->setEvent($this->event);
    }

    public function testIndexAction_WithGetRequest()
    {
        $bookEntityOne = $this->bookEntityProvider->getBookEntityWithRandomData();
        $bookEntityTwo = $this->bookEntityProvider->getBookEntityWithRandomData();

        $books = [
            $bookEntityOne,
            $bookEntityTwo
        ];

        $paginatorMock = $this->getMockBuilder(PaginatorAdapter::class)
            ->disableOriginalConstructor()
            ->setMethods(array('count', 'getIterator'))
            ->getMock();

        $paginatorMock->expects($this->any())
            ->method('count')
            ->willReturn(2);

        $paginatorMock->expects($this->any())
            ->method('getIterator')
            ->willReturn($books);

        $this->filterResultsServiceMock->expects($this->once())
            ->method('getFilteredResults')
            ->will($this->returnValue($paginatorMock));

        $paginator = new PaginatorInfo(2, 1, 10);

        $this->paginatorInfoFactoryMock->expects($this->once())
            ->method('create')
            ->with(2)
            ->willReturn($paginator);

        $result = $this->controller->dispatch(new Request());

        $this->assertResponseStatusCode(Response::STATUS_CODE_200);

        $expectedResult = array(
            'books' => $books,
            'paginator' => $paginator,
            'route' => 'library/books/*',
            'query' => array(
                '$page' => 1,
                '$limit' => 10
            )
        );

        $this->assertSame($expectedResult, $result);
    }

    public function testIndexAction_WithUnrecognizedFieldException()
    {
        $this->filterResultsServiceMock->expects($this->once())
            ->method('getFilteredResults')
            ->will(
                $this->throwException(
                    new UnrecognizedFieldException(
                        sprintf('Field unrecognized in entity: %s', 'author')
                    )
                )
            );

        $result = $this->controller->dispatch(new Request());

        $this->assertResponseStatusCode(Response::STATUS_CODE_200);
        $this->assertSame(['books' => []], $result);

        $messages = $this->controller->flashMessenger()->getCurrentErrorMessages();
        $this->assertSame(['Field unrecognized in entity: author'], $messages);
    }

    public function testIndexAction_WithUnsupportedTypeException()
    {
        $this->filterResultsServiceMock->expects($this->once())
            ->method('getFilteredResults')
            ->will(
                $this->throwException(
                    new UnsupportedTypeException(
                        sprintf('Unsupported condition type: %s', '$inarray')
                    )
                )
            );

        $result = $this->controller->dispatch(new Request());

        $this->assertResponseStatusCode(Response::STATUS_CODE_200);
        $this->assertSame(['books' => []], $result);

        $messages = $this->controller->flashMessenger()->getCurrentErrorMessages();
        $this->assertSame(['Unsupported condition type: $inarray'], $messages);
    }

}