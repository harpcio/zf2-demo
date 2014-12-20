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

namespace LibraryTest\Collection\Provider;

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