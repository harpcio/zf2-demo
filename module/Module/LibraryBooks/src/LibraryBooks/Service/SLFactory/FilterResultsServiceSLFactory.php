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

namespace Module\LibraryBooks\Service\SLFactory;

use Library\QueryFilter\Command\Repository;
use BusinessLogic\Books\Repository\BooksRepository;
use Module\LibraryBooks\Service\FilterResultsService;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class FilterResultsServiceSLFactory implements FactoryInterface
{

    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     *
     * @return FilterResultsService
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /**
         * @var $bookRepository BooksRepository
         */
        $bookRepository = $serviceLocator->get(BooksRepository::class);
        $commandCollection = $serviceLocator->get(Repository\CommandCollection::class);

        return new FilterResultsService($bookRepository, $commandCollection);
    }
}
