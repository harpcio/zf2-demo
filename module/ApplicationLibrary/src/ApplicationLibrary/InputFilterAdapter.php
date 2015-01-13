<?php

namespace ApplicationLibrary;

use Zend\Inputfilter\InputFilterInterface as ZendInputFilterInterface;

class InputFilterAdapter implements InputFilterInterface
{
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