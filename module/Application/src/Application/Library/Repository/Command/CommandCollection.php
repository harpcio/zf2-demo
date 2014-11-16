<?php

namespace Application\Library\Repository\Command;

use Application\Library\Collection\InterfaceCollection;

class CommandCollection extends InterfaceCollection
{
    protected $interface = CommandInterface::class;
}