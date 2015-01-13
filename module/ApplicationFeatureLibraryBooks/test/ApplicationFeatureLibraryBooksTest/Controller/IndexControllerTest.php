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

use BusinessLogicDomainBooksTest\Entity\Provider\BookEntityProvider;
use ApplicationLibrary\QueryFilter\Exception\UnrecognizedFieldException;
use ApplicationLibrary\QueryFilter\Exception\UnsupportedTypeException;
use ApplicationLibrary\QueryFilter\QueryFilter;
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