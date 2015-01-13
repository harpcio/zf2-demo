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

namespace ApplicationFeatureApiV1LibraryBooks\Controller;

use ApplicationFeatureApi\Controller\AbstractApiActionController;
use ApplicationFeatureApi\Exception;
use ApplicationFeatureLibraryBooks\Service\FilterResultsService;
use ApplicationLibrary\QueryFilter\Exception\UnrecognizedFieldException;
use ApplicationLibrary\QueryFilter\Exception\UnsupportedTypeException;
use ApplicationLibrary\QueryFilter\QueryFilter;
use Doctrine\ORM\Query;
use Zend\Http\Response;
use Zend\View\Model\JsonModel;

class GetListController extends AbstractApiActionController
{

    /**
     * @var FilterResultsService
     */
    private $service;

    /**
     * @var QueryFilter
     */
    private $queryFilter;

    public function __construct(FilterResultsService $service, QueryFilter $queryFilter)
    {
        $this->service = $service;
        $this->queryFilter = $queryFilter;
    }

    public function indexAction()
    {
        try {
            $this->queryFilter->setQueryParameters($this->params()->fromQuery());
            $books = $this->service->getFilteredResults($this->queryFilter, $hydrationMode = Query::HYDRATE_ARRAY);

            return new JsonModel(['data' => $books]);
        } catch (UnrecognizedFieldException $e) {
            throw new Exception\BadRequestException($e->getMessage(), Response::STATUS_CODE_400, $e);
        } catch (UnsupportedTypeException $e) {
            throw new Exception\BadRequestException($e->getMessage(), Response::STATUS_CODE_400, $e);
        } catch (\PDOException $e) {
            throw new Exception\PDOServiceUnavailableException();
        }
    }
}