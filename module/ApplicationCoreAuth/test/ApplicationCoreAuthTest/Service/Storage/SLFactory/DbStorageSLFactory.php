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

namespace ApplicationCoreAuthTest\Service\Storage\SLFactory;

use ApplicationCoreAuth\Service\Storage\DbStorage;
use ApplicationCoreAuth\Service\Storage\SLFactory\DbStorageSLFactory;
use Test\Bootstrap;

class DbStorageSLFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var DbStorageSLFactory
     */
    private $testedObj;

    public function setUp()
    {
        $this->testedObj = new DbStorageSLFactory();
    }

    public function testCreateService()
    {
        $result = $this->testedObj->createService(Bootstrap::getServiceManager());

        $this->assertInstanceOf(DbStorage::class, $result);
    }
}