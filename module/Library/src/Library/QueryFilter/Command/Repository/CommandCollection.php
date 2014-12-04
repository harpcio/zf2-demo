<?php

namespace Library\QueryFilter\Command\Repository;

use Library\Collection\AbstractInterfaceTypeCollection;

class CommandCollection extends AbstractInterfaceTypeCollection
{
    protected $interfaceOrObjectName = CommandInterface::class;
}