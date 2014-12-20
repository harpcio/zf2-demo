<?php
/**
 * This file is part of Zf2-demo package
 *
 * @author Rafal Ksiazek <harpcio@gmail.com>
 * @copyright Rafal Ksiazek F.H.U. Studioars
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

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