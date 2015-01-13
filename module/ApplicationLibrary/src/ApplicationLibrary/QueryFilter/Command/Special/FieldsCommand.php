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

namespace ApplicationLibrary\QueryFilter\Command\Special;

use ApplicationLibrary\QueryFilter\Command\CommandInterface;
use ApplicationLibrary\QueryFilter\Criteria;
use ApplicationLibrary\QueryFilter\QueryFilter;

class FieldsCommand implements CommandInterface
{
    public static $commandName = '$fields';

    public function execute($key, $value, QueryFilter $queryFilter)
    {
        if ($key !== static::$commandName) {
            return false;
        }

        $value = explode(',', $value);
        $value = array_map('trim', $value);

        $queryFilter->addCriteria(new Criteria(Criteria::TYPE_SPECIAL_FIELDS, null, $value));

        return true;
    }
}