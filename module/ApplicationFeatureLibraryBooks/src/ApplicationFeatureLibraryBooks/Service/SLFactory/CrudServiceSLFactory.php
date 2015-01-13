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

namespace ApplicationFeatureLibraryBooks\Service\SLFactory;

use BusinessLogicDomainBooks\Repository\BooksRepository;
use ApplicationFeatureLibraryBooks\Service\CrudService;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class CrudServiceSLFactory implements FactoryInterface
{

    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     *
     * @return CrudService
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /**
         * @var $bookRepository BooksRepository
         */
        $bookRepository = $serviceLocator->get(BooksRepository::class);

        return new CrudService($bookRepository);
    }
}
