<?php

namespace Application\Library\QueryFilter\Command\Repository;

use Application\Library\Collection\InterfaceCollection;
use Application\Library\QueryFilter\Command\Repository\CommandInterface;

class CommandCollection extends InterfaceCollection
{
    protected $interface = CommandInterface::class;
}