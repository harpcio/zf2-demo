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

class FieldsCommand extends AbstractCommand
{
    /**
     * @var string
     */
    protected $commandName = '$fields';

    public function execute(array $query, QueryFilter $queryFilter)
    {
        if (!isset($query[$this->commandName])) {
            return false;
        }

        $value = $query[$this->commandName];

        $value = explode(',', $value);
        $value = array_map('trim', $value);

        $queryFilter->addCriteria(
            new Criteria(
                Criteria::TYPE_SPECIAL_FIELDS,
                $value,
                null
            )
        );

        return true;
    }
}