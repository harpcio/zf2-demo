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

namespace BusinessLogic\UsersTest\Repository\SLFactory;

use BusinessLogic\Users\Repository\SLFactory\UsersRepositorySLFactory;
use BusinessLogic\Users\Repository\UsersRepository;
use Test\Bootstrap;

Class ManagerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var UsersRepositorySLFactory
     */
    private $testedObject;

    public function setUp()
    {
        $this->testedObject = new UsersRepositorySLFactory();
    }

    public function testCreate()
    {
        $result = $this->testedObject->createService(Bootstrap::getServiceManager());

        $this->assertInstanceOf(UsersRepository::class, $result);
    }
}