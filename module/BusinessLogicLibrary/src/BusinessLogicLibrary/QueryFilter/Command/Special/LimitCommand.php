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

namespace BusinessLogicLibrary\QueryFilter\Command\Special;

use BusinessLogicLibrary\QueryFilter\Criteria;
use BusinessLogicLibrary\QueryFilter\QueryFilter;

class LimitCommand extends AbstractCommand
{
    /**
     * @var string
     */
    protected $commandName = '$limit';

    public function execute(array $query, QueryFilter $queryFilter)
    {
        if (!isset($query[$this->commandName])) {
            return false;
        }

        $value = $query[$this->commandName];

        $queryFilter->addCriteria(
            new Criteria(
                Criteria::TYPE_SPECIAL_LIMIT,
                null,
                (int)$value
            )
        );

        return true;
    }
}