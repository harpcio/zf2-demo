<?php

namespace Library\Traits;

use DoctrineModule\Stdlib\Hydrator\DoctrineObject;

trait DoctrineHydratorAwareTrait
{
    /**
     * @var DoctrineObject;
     */
    protected $hydrator;

    public function setHydrator(DoctrineObject $hydrator)
    {
        $this->hydrator = $hydrator;
    }

    /**
     * @return DoctrineObject
     * @throws \LogicException
     */
    protected function getHydrator()
    {
        if (!$this->hydrator) {
            throw new \LogicException('Hydrator has not been injected!');
        }

        return $this->hydrator;
    }

}