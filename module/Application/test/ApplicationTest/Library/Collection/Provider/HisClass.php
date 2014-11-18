<?php

namespace ApplicationTest\Library\Collection\Provider;

class HisClass implements MyClassInterface
{
    /**
     * @var int
     */
    protected $a;

    /**
     * @var int
     */
    protected $b;

    public function __construct($a, $b)
    {
        $this->setA($a);
        $this->setB($b);
    }

    /**
     * @param int $a
     */
    public function setA($a)
    {
        $this->a = (int)$a;
    }

    /**
     * @return int
     */
    public function getA()
    {
        return $this->a;
    }

    /**
     * @param int $b
     */
    public function setB($b)
    {
        $this->b = (int)$b;
    }

    /**
     * @return int
     */
    public function getB()
    {
        return $this->b;
    }
}