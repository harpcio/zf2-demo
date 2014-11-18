<?php

namespace ApplicationTest\Library\Collection\Provider;

interface MyClassInterface
{
    /**
     * @param mixed $a
     */
    public function setA($a);

    /**
     * @param mixed $b
     */
    public function setB($b);

    /**
     * @return mixed
     */
    public function getA();

    /**
     * @return mixed
     */
    public function getB();
}