<?php

namespace LibraryTest\Collection\Provider;

use Library\Collection\AbstractInterfaceTypeCollection;

class MyClassInterfaceCollection extends AbstractInterfaceTypeCollection
{
    protected $type = MyClassInterface::class;
}