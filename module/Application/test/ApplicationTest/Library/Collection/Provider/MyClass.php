<?php

namespace ApplicationTest\Library\Collection\Provider;

class MyClass implements MyClassInterface
{
    protected $a;

    protected $b;

    public function __construct($a, $b)
    {
        $this->setA($a);
        $this->setB($b);
    }

    /**
     * @param mixed $a
     */
    public function setA($a)
    {
        $this->a = $a;
    }

    /**
     * @return mixed
     */
    public function getA()
    {
        return $this->a;
    }

    /**
     * @param mixed $b
     */
    public function setB($b)
    {
        $this->b = $b;
    }

    /**
     * @return mixed
     */
    public function getB()
    {
        return $this->b;
    }
}