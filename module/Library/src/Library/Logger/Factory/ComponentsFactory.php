<?php

namespace Library\Logger\Factory;

use Zend\Log\Filter\Priority;
use Zend\Log\Logger;
use Zend\Log\Writer\Stream;

class ComponentsFactory
{
    /**
     * @return Logger
     */
    public function createLogger()
    {
        return new Logger();
    }

    /**
     * @param int  $priority
     * @param null $operator
     *
     * @return Priority
     */
    public function createPriority($priority, $operator = null)
    {
        return new Priority($priority, $operator);
    }

    /**
     * @param  string|resource|array|\Traversable $streamOrUrl
     * @param  string|null                        $mode
     * @param  null|string                        $logSeparator
     *
     * @return Stream
     */
    public function createStreamWriter($streamOrUrl, $mode = null, $logSeparator = null)
    {
        return new Stream($streamOrUrl, $mode, $logSeparator);
    }
}