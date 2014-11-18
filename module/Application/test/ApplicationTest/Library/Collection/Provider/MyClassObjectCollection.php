<?php

namespace ApplicationTest\Library\Collection\Provider;

use Application\Library\Collection\AbstractObjectTypeCollection;

class MyClassObjectCollection extends AbstractObjectTypeCollection
{
    protected $type = MyClass::class;
}