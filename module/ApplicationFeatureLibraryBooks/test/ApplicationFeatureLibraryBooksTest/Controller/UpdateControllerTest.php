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
use Doctrine\ORM\EntityNotFoundException;
use ApplicationLibraryTest\Controller\AbstractControllerTestCase;
use ApplicationFeatureLibraryBooks\Controller\UpdateController;
use ApplicationFeatureLibraryBooks\Form\CreateForm;
use ApplicationFeatureLibraryBooks\Service\CrudService;
use PHPUnit_Framework_MockObject_MockObject as MockObject;
use Zend\Http\Request;
use Zend\Http\Response;
use Zend\InputFilter\InputFilterInterface;
use Zend\Stdlib\Parameters;

class UpdateControllerTest extends AbstractControllerTestCase
{
    /**
     * @var BookEntityProvider
     */
    private $bookEntityProvider;

    /**
     * @var MockObject
     */
    private $crudServiceMock;

    /**
     * @var MockObject
     */
    private $createFormMock;

    /**
     * @var UpdateController
     */
    protected $controller;

    public function setUp()
    {
        $this->init('update');

        $this->bookEntityProvider = new BookEntityProvider();

        $this->crudServiceMock = $this->getMockBuilder(CrudService::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->createFormMock = $this->getMockBuilder(CreateForm::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->controller = new UpdateController($this->createFormMock, $this->crudServiceMock);
        $this->controller->setEvent($this->event);
    }

    public function testIndexAction_WithGetRequest()
    {
        $bookEntity = $this->bookEntityProvider->getBookEntityWithRandomData();
        $id = $bookEntity->getId();
        $data = $this->bookEntityProvider->getDataFromBookEntity($bookEntity, false);

        $this->crudServiceMock->expects($this->once())
            ->method('getById')
            ->with($id)
            ->will($this->returnValue($bookEntity));

        $this->createFormMock->expects($this->once())
            ->method('get')
            ->with('submit')
            ->will($this->returnSelf());

        $this->createFormMock->expects($this->once())
            ->method('setValue')
            ->with('Update');

        $this->crudServiceMock->expects($this->once())
            ->method('extractEntity')
            ->with($bookEntity)
            ->will($this->returnValue($data));

        $this->createFormMock->expects($this->once())
            ->method('setData')
            ->with($data);

        $this->routeMatch->setParam('id', $id);
        $result = $this->controller->dispatch(new Request());

        $this->assertResponseStatusCode(Response::STATUS_CODE_200);
        $this->assertSame(
            [
                'form' => $this->createFormMock
            ],
            $result
        );
    }

    public function testIndexAction_WithValidPostRequest()
    {
        $bookEntity = $this->bookEntityProvider->getBookEntityWithRandomData();
        $id = $bookEntity->getId();

        $newBookEntity = $this->bookEntityProvider->getBookEntityWithRandomData();
        $data = $this->bookEntityProvider->getDataFromBookEntity($newBookEntity, false);

        $inputFilterMock = $this->getMock(InputFilterInterface::class);

        $this->crudServiceMock->expects($this->once())
            ->method('getById')
            ->with($id)
            ->will($this->returnValue($bookEntity));

        $this->createFormMock->expects($this->once())
            ->method('get')
            ->with('submit')
            ->will($this->returnSelf());

        $this->createFormMock->expects($this->once())
            ->method('setValue')
            ->with('Update');

        $this->createFormMock->expects($this->once())
            ->method('setData')
            ->with($data);

        $this->createFormMock->expects($this->once())
            ->method('isValid')
            ->will($this->returnValue(true));

        $this->createFormMock->expects($this->once())
            ->method('getInputFilter')
            ->will($this->returnValue($inputFilterMock));

        $this->crudServiceMock->expects($this->once())
            ->method('update')
            ->with($bookEntity, $inputFilterMock);

        $this->routeMatch->setParam('id', $id);

        $result = $this->controller->dispatch(
            (new Request())
                ->setMethod(Request::METHOD_POST)
                ->setPost(new Parameters($data))
        );

        $this->assertResponseStatusCode(Response::STATUS_CODE_200);
        $this->assertSame(
            [
                'form' => $this->createFormMock
            ],
            $result
        );
    }

    public function testIndexAction_WithInValidPostRequest()
    {
        $bookEntity = $this->bookEntityProvider->getBookEntityWithRandomData();
        $id = $bookEntity->getId();

        $data = [];

        $this->crudServiceMock->expects($this->once())
            ->method('getById')
            ->with($id)
            ->will($this->returnValue($bookEntity));

        $this->createFormMock->expects($this->once())
            ->method('get')
            ->with('submit')
            ->will($this->returnSelf());

        $this->createFormMock->expects($this->once())
            ->method('setValue')
            ->with('Update');

        $this->createFormMock->expects($this->once())
            ->method('setData')
            ->with($data);

        $this->createFormMock->expects($this->once())
            ->method('isValid')
            ->will($this->returnValue(false));

        $this->routeMatch->setParam('id', $id);

        $result = $this->controller->dispatch(
            (new Request())
                ->setMethod(Request::METHOD_POST)
                ->setPost(new Parameters($data))
        );

        $this->assertResponseStatusCode(Response::STATUS_CODE_200);
        $this->assertSame(
            [
                'form' => $this->createFormMock
            ],
            $result
        );
    }

    public function testIndexAction_WithExceptionInService()
    {
        $bookEntity = $this->bookEntityProvider->getBookEntityWithRandomData();
        $id = $bookEntity->getId();

        $data = [];

        $this->crudServiceMock->expects($this->once())
            ->method('getById')
            ->with($id)
            ->will($this->throwException(new EntityNotFoundException()));

        $this->routeMatch->setParam('id', $id);

        $this->controller->dispatch(
            (new Request())
                ->setMethod(Request::METHOD_POST)
                ->setPost(new Parameters($data))
        );

        $this->assertResponseStatusCode(Response::STATUS_CODE_302);
        $this->assertRedirectTo('/library/books');
    }

}