<?php

namespace ApplicationTest\Library\Collection\Provider;

use Application\Library\Collection\AbstractInterfaceTypeCollection;

class MyClassInterfaceCollection extends AbstractInterfaceTypeCollection
{
    protected $type = MyClassInterface::class;
}