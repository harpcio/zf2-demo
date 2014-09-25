<?php

namespace Application\Library\Traits;

use DoctrineModule\Stdlib\Hydrator\DoctrineObject;

interface DoctrineHydratorAwareInterface
{
    public function setHydrator(DoctrineObject $hydrator);

    public function getHydrator();
}

