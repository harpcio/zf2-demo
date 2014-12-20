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

namespace Library\Logger;

use Zend\Log\Logger;

class Manager
{
    /**
     * @var Factory\ComponentsFactory
     */
    private $componentsFactory;

    /**
     * @var string
     */
    private $defaultPath;

    /**
     * @var string
     */
    private $defaultSeparator;

    public function __construct(Factory\ComponentsFactory $componentsFactory)
    {
        $this->componentsFactory = $componentsFactory;

        $this->defaultPath = ROOT_PATH . '/data/log/';
        $this->defaultSeparator = PHP_EOL . '-' . PHP_EOL;
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
        $path = $this->preparePath($path);
        $separator = $this->prepareSeparator($separator);

        $logger = $this->componentsFactory->createLogger();

        $filePathName = $path . date('Ymd') . sprintf('.%s.error.log', $name);
        $errorWriter = $this->componentsFactory->createStreamWriter($filePathName, null, $separator);
        $errorFilter = $this->componentsFactory->createPriority(Logger::ERR, '<=');
        $errorWriter->addFilter($errorFilter);
        $logger->addWriter($errorWriter);

        $filePathName = $path . date('Ymd') . sprintf('.%s.info.log', $name);
        $errorWriter = $this->componentsFactory->createStreamWriter($filePathName, null, $separator);
        $errorFilter = $this->componentsFactory->createPriority(Logger::WARN, '>=');
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
        $path = $this->preparePath($path);
        $separator = $this->prepareSeparator($separator);

        $logger = $this->componentsFactory->createLogger();

        $filePathName = $path . date('Ymd') . sprintf('.%s.log', $name);
        $errorWriter = $this->componentsFactory->createStreamWriter($filePathName, null, $separator);
        $logger->addWriter($errorWriter);

        return $logger;
    }

    /**
     * @param string|null $path
     *
     * @return string
     */
    private function preparePath($path = null)
    {
        if (null !== $path && is_dir($path)) {
            return rtrim($path, '/') . '/';
        }

        return $this->defaultPath;
    }

    /**
     * @param string|null $separator
     *
     * @return string
     */
    private function prepareSeparator($separator = null)
    {
        if (null !== $separator) {
            return $separator;
        }

        return $this->defaultSeparator;
    }
}