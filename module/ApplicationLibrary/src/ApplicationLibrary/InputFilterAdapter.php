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

namespace ApplicationLibrary;

use BusinessLogicLibrary\InputFilterInterface;
use Zend\Inputfilter\InputFilterInterface as ZendInputFilterInterface;

class InputFilterAdapter implements InputFilterInterface
{
    /**
     * @var ZendInputFilterInterface
     */
    private $inputFilter;

    public function __construct(ZendInputFilterInterface $inputFilter)
    {
        $this->inputFilter = $inputFilter;
    }

    /**
     * @return bool
     */
    public function isValid()
    {
        return $this->inputFilter->isValid();
    }

    /**
     * @return array
     */
    public function getValues()
    {
        return $this->inputFilter->getValues();
    }

    /**
     * @param string $name
     * @return mixed
     */
    public function getValue($name)
    {
        return $this->inputFilter->getValue($name);
    }
}