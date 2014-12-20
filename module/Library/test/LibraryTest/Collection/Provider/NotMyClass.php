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

class NotMyClass
{
    /**
     * @var boolean
     */
    protected $c;

    /**
     * @var \DateTime
     */
    protected $d;

    public function __construct($a, $b)
    {
        $this->setC($a);
        $this->setD($b);
    }

    /**
     * @param boolean $c
     */
    public function setC($c)
    {
        $this->c = $c;
    }

    /**
     * @return boolean
     */
    public function getC()
    {
        return $this->c;
    }

    /**
     * @param \DateTime $d
     */
    public function setD($d)
    {
        $this->d = $d;
    }

    /**
     * @return \DateTime
     */
    public function getD()
    {
        return $this->d;
    }

}