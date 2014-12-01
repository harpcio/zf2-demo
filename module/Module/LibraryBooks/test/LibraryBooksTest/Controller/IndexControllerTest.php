<?php

namespace Module\LibraryBooksTest\Controller;

use BusinessLogic\BooksTest\Entity\Provider\BookEntityProvider;
use Library\QueryFilter\Exception\UnrecognizedFieldException;
use Library\QueryFilter\Exception\UnsupportedTypeException;
use Library\QueryFilter\QueryFilter;
use LibraryTest\Controller\AbstractControllerTestCase;
use Module\LibraryBooks\Controller\IndexController;
use Module\LibraryBooks\Service\FilterResultsService;
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
     * @var MockObject
     */
    private $filterResultsServiceMock;

    /**
     * @var QueryFilter
     */
    private $queryFilter;

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

        $this->controller = new IndexController($this->filterResultsServiceMock, $this->queryFilter);
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

        $this->filterResultsServiceMock->expects($this->once())
            ->method('getFilteredResults')
            ->will($this->returnValue($books));

        $result = $this->controller->dispatch(new Request());

        $this->assertResponseStatusCode(Response::STATUS_CODE_200);
        $this->assertSame(['books' => $books], $result);
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