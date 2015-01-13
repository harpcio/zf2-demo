<?php

namespace ApplicationLibrary;

interface InputFilterInterface
{
    /**
     * @return bool
     */
    public function isValid();

    /**
     * @return array
     */
    public function getValues();

    /**
     * @param string $name
     * @return mixed
     */
    public function getValue($name);
}