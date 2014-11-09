<?php

namespace Application\Library\Logger;

use Zend\Log\Filter\Priority;
use Zend\Log\Logger;
use Zend\Log\Writer\Stream;

class Manager
{
    /**
     * @var string
     */
    private $path;

    /**
     * @var string
     */
    private $separator;

    public function __construct()
    {
        $this->path = ROOT_PATH . '/data/log/';
        $this->separator = PHP_EOL . '-' . PHP_EOL;
    }

    /**
     * @param string      $name
     * @param string|null $path
     * @param string|null $separator
     *
     * @return Logger
     */
    public function createErrorInfoLog($name = 'app', $path = null, $separator = null)
    {
        $this->preparePath($path);
        $this->prepareSeparator($separator);

        $logger = new Logger();

        $filePathName = $this->path . date('Ymd') . sprintf('%s.error.log', $name);
        $errorWriter = new Stream($filePathName, null, $this->separator);
        $errorFilter = new Priority(Logger::ERR, '<=');
        $errorWriter->addFilter($errorFilter);
        $logger->addWriter($errorWriter);

        $filePathName = $this->path . date('Ymd') . sprintf('%s.info.log', $name);
        $errorWriter = new Stream($filePathName, null, $this->separator);
        $errorFilter = new Priority(Logger::WARN, '>=');
        $errorWriter->addFilter($errorFilter);
        $logger->addWriter($errorWriter);

        return $logger;
    }

    /**
     * @param string      $name
     * @param string|null $path
     * @param string|null $separator
     *
     * @return Logger
     */
    public function createLog($name = 'app', $path = null, $separator = null)
    {
        $this->preparePath($path);
        $this->prepareSeparator($separator);

        $logger = new Logger();

        $filePathName = $this->path . date('Ymd') . sprintf('%s.log', $name);
        $errorWriter = new Stream($filePathName, null, $this->separator);
        $logger->addWriter($errorWriter);

        return $logger;
    }

    private function preparePath($path = null)
    {
        if (null !== $path && is_dir($path)) {
            $this->path = $path;
        }
    }

    private function prepareSeparator($separator = null)
    {
        if (null !== $separator) {
            $this->separator = $separator;
        }
    }
}