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
use ApplicationLibraryTest\Controller\AbstractControllerTestCase;
use ApplicationFeatureLibraryBooks\Controller\CreateController;
use ApplicationFeatureLibraryBooks\Form\CreateForm;
use ApplicationFeatureLibraryBooks\Service\CrudService;
use PHPUnit_Framework_MockObject_MockObject as MockObject;
use Zend\Http\Request;
use Zend\Http\Response;
use Zend\InputFilter\InputFilterInterface;
use Zend\Stdlib\Parameters;

class CreateControllerTest extends AbstractControllerTestCase
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
     * @var CreateController
     */
    protected $controller;

    public function setUp()
    {
        $this->init('create');

        $this->bookEntityProvider = new BookEntityProvider();

        $this->crudServiceMock = $this->getMockBuilder(CrudService::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->createFormMock = $this->getMockBuilder(CreateForm::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->controller = new CreateController($this->createFormMock, $this->crudServiceMock);
        $this->controller->setEvent($this->event);
    }

    public function testIndexAction_WithGetRequest()
    {
        $this->createFormMock->expects($this->once())
            ->method('get')->will($this->returnSelf());

        $this->createFormMock->expects($this->once())
            ->method('setValue')->with('Create');

        $this->crudServiceMock->expects($this->never())
            ->method('create');

        $result = $this->controller->dispatch(
            (new Request())
                ->setMethod(Request::METHOD_GET)
        );

        $this->assertResponseStatusCode(Response::STATUS_CODE_200);
        $this->assertSame(['form' => $this->createFormMock], $result);
    }

    public function testIndexAction_WithValidPostRequest()
    {
        $bookEntity = $this->bookEntityProvider->getBookEntityWithRandomData();
        $data = $this->bookEntityProvider->getDataFromBookEntity($bookEntity, false);
        $data['csrf'] = 'csrfToken';

        $entityId = $bookEntity->getId();
        $inputFilterMock = $this->getMock(InputFilterInterface::class);

        $this->createFormMock->expects($this->once())
            ->method('get')->will($this->returnSelf());

        $this->createFormMock->expects($this->once())
            ->method('setValue')->with('Create');

        $this->createFormMock->expects($this->once())
            ->method('setData')->with($data);

        $this->createFormMock->expects($this->once())
            ->method('isValid')->will($this->returnValue(true));

        $this->createFormMock->expects($this->once())
            ->method('getInputFilter')->will($this->returnValue($inputFilterMock));

        $this->crudServiceMock->expects($this->once())
            ->method('create')
            ->with($inputFilterMock)
            ->will($this->returnValue($bookEntity));

        $this->controller->dispatch(
            (new Request())
                ->setMethod(Request::METHOD_POST)
                ->setPost(new Parameters($data))
        );

        $this->assertResponseStatusCode(Response::STATUS_CODE_302);
        $this->assertRedirectTo('/library/books/update/' . $entityId);
    }

    public function testIndexAction_WithInValidPostRequest()
    {
        $bookEntity = $this->bookEntityProvider->getBookEntityWithRandomData();
        $data = $this->bookEntityProvider->getDataFromBookEntity($bookEntity, false);
        $data['csrf'] = 'csrfToken';

        $this->createFormMock->expects($this->once())
            ->method('get')->will($this->returnSelf());

        $this->createFormMock->expects($this->once())
            ->method('setValue')->with('Create');

        $this->createFormMock->expects($this->once())
            ->method('setData')->with($data);

        $this->createFormMock->expects($this->once())
            ->method('isValid')->will($this->returnValue(false));

        $result = $this->controller->dispatch(
            (new Request())
                ->setMethod(Request::METHOD_POST)
                ->setPost(new Parameters($data))
        );

        $this->assertResponseStatusCode(Response::STATUS_CODE_200);
        $this->assertSame(['form' => $this->createFormMock], $result);
    }

    public function testIndexAction_WithExceptionInService()
    {
        $bookEntity = $this->bookEntityProvider->getBookEntityWithRandomData();
        $data = $this->bookEntityProvider->getDataFromBookEntity($bookEntity, false);
        $data['csrf'] = 'csrfToken';

        $inputFilterMock = $this->getMock(InputFilterInterface::class);

        $this->createFormMock->expects($this->once())
            ->method('get')->will($this->returnSelf());

        $this->createFormMock->expects($this->once())
            ->method('setValue')->with('Create');

        $this->createFormMock->expects($this->once())
            ->method('setData')->with($data);

        $this->createFormMock->expects($this->once())
            ->method('isValid')->will($this->returnValue(true));

        $this->createFormMock->expects($this->once())
            ->method('getInputFilter')->will($this->returnValue($inputFilterMock));

        $this->crudServiceMock->expects($this->once())
            ->method('create')
            ->with($inputFilterMock)
            ->will($this->throwException(new \InvalidArgumentException('Some error')));

        $this->controller->dispatch(
            (new Request())
                ->setMethod(Request::METHOD_POST)
                ->setPost(new Parameters($data))
        );

        $this->assertResponseStatusCode(Response::STATUS_CODE_302);
        $this->assertRedirectTo('/library/books');
    }
}