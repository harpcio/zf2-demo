<?php

namespace LibraryTest\Logger\Factory;

use Library\Logger\Factory\ComponentsFactory;
use Zend\Log\Filter\Priority;
use Zend\Log\Logger;
use Zend\Log\LoggerInterface;
use Zend\Log\Writer\Stream;

Class ComponentsFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ComponentsFactory
     */
    private $testedObject;

    const FILE_PATH = '/test/data/test.log';

    public function setUp()
    {
        $this->testedObject = new ComponentsFactory();
    }

    public static function tearDownAfterClass()
    {
        parent::tearDownAfterClass();

        $filePath = ROOT_PATH . self::FILE_PATH;
        unlink($filePath);
    }

    public function testCreateLogger()
    {
        $result = $this->testedObject->createLogger();

        $this->assertInstanceOf(LoggerInterface::class, $result);
    }

    public function testCreatePriority()
    {
        $result = $this->testedObject->createPriority(Logger::WARN, '>=');

        $this->assertInstanceOf(Priority::class, $result);
    }

    public function testCreateStreamWriter()
    {
        $filePath = ROOT_PATH . self::FILE_PATH;

        $result = $this->testedObject->createStreamWriter($filePath, null, '---');

        $this->assertInstanceOf(Stream::class, $result);
        $this->assertTrue(file_exists($filePath));
    }

}