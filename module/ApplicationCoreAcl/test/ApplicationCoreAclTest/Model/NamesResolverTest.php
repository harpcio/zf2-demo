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

namespace ApplicationCoreAclTest\Model;

use ApplicationCoreAcl\Model\NamesResolver;
use ApplicationCoreAclTest\Model\Provider\Controller\AbcController;
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

        $this->assertSame('applicationcoreacltest\\model\\provider', $module);
        $this->assertSame('abc', $controller);
        $this->assertSame('def', $action);
    }
}