<?php

namespace Module\ApiV1LibraryBooksTest\Controller;

use LibraryTest\Controller\AbstractFunctionalControllerTestCase;
use Test\Bootstrap;
use Zend\Http\Request;
use Zend\Http\Response;

class BooksControllerFunctionalTest extends AbstractFunctionalControllerTestCase
{
    const WITHOUT_IDENTIFIER_URL = '/api/library/books';
    const WITH_IDENTIFIER_URL = '/api/library/books/1';

    public function setUp()
    {
        parent::setUp();
    }

    public function tearDown()
    {
        parent::tearDown();
        
        Bootstrap::setupServiceManager();
    }

    public function testOptionsRequest_WithIdentifierUrl()
    {
        $this->dispatch(self::WITH_IDENTIFIER_URL, Request::METHOD_OPTIONS);

        /** @var \Zend\Http\Header\Allow $allowHeader */
        $allowHeader = $this->getResponseHeader('Allow');
        $this->assertTrue($allowHeader->isAllowedMethod(Request::METHOD_OPTIONS));
        $this->assertTrue($allowHeader->isAllowedMethod(Request::METHOD_GET));
        $this->assertTrue($allowHeader->isAllowedMethod(Request::METHOD_PUT));
        $this->assertTrue($allowHeader->isAllowedMethod(Request::METHOD_DELETE));

        $this->assertFalse($allowHeader->isAllowedMethod(Request::METHOD_HEAD));
        $this->assertFalse($allowHeader->isAllowedMethod(Request::METHOD_POST));
        $this->assertFalse($allowHeader->isAllowedMethod(Request::METHOD_TRACE));
        $this->assertFalse($allowHeader->isAllowedMethod(Request::METHOD_CONNECT));
        $this->assertFalse($allowHeader->isAllowedMethod(Request::METHOD_PATCH));
    }

    public function testOptionsRequest_WithoutIdentifierUrl()
    {
        $this->dispatch(self::WITHOUT_IDENTIFIER_URL, Request::METHOD_OPTIONS);

        /** @var \Zend\Http\Header\Allow $allowHeader */
        $allowHeader = $this->getResponseHeader('Allow');
        $this->assertTrue($allowHeader->isAllowedMethod(Request::METHOD_OPTIONS));
        $this->assertTrue($allowHeader->isAllowedMethod(Request::METHOD_GET));
        $this->assertTrue($allowHeader->isAllowedMethod(Request::METHOD_POST));

        $this->assertFalse($allowHeader->isAllowedMethod(Request::METHOD_DELETE));
        $this->assertFalse($allowHeader->isAllowedMethod(Request::METHOD_HEAD));
        $this->assertFalse($allowHeader->isAllowedMethod(Request::METHOD_PUT));
        $this->assertFalse($allowHeader->isAllowedMethod(Request::METHOD_TRACE));
        $this->assertFalse($allowHeader->isAllowedMethod(Request::METHOD_CONNECT));
        $this->assertFalse($allowHeader->isAllowedMethod(Request::METHOD_PATCH));
    }

}