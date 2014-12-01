<?php

namespace LibraryTest\Collection\Provider;

use Library\Collection\AbstractObjectTypeCollection;

class MyClassObjectCollection extends AbstractObjectTypeCollection
{
    protected $type = MyClass::class;
}