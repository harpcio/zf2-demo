<?php

namespace AclTest\Model;

use Acl\Model\NamesResolver;
use AclTest\Model\Provider\Controller\AbcController;
use Zend\Mvc\MvcEvent;
use Zend\Mvc\Router\Http\RouteMatch;

class NamesResolverTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var NamesResolver
     */
    private $testedObject;

    public function setUp()
    {
        $this->testedObject = new NamesResolver();
    }

    public function testResolve()
    {
        $event = new MvcEvent();

        $controller = new AbcController();
        $event->setTarget($controller);

        $routeMatch = new RouteMatch(['action' => 'def']);
        $event->setRouteMatch($routeMatch);

        list($module, $controller, $action) = $this->testedObject->resolve($event);

        $this->assertSame('acltest\\model\\provider', $module);
        $this->assertSame('abc', $controller);
        $this->assertSame('def', $action);
    }
}