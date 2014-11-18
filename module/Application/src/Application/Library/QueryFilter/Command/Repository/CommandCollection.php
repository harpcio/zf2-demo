<?php

namespace Application\Library\QueryFilter\Command\Repository;

use Application\Library\Collection\AbstractInterfaceTypeCollection;

class CommandCollection extends AbstractInterfaceTypeCollection
{
    protected $type = CommandInterface::class;
}