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
use BusinessLogicLibrary\Pagination\PaginatorAdapter;
use BusinessLogicLibrary\QueryFilter\Exception\QueryFilterException;
use BusinessLogicLibrary\QueryFilter\QueryFilter;
use BusinessLogicLibrary\Pagination\PaginatorInfoFactory;
use BusinessLogicLibrary\Pagination\Exception\PaginationException;
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
     * @var \BusinessLogicLibrary\QueryFilter\QueryFilter
     */
    private $queryFilter;

    /**
     * @var PaginatorInfoFactory
     */
    private $paginatorInfoFactory;

    public function __construct(
        FilterResultsService $service,
        QueryFilter $queryFilter,
        PaginatorInfoFactory $paginatorInfoFactory
    ) {
        $this->service = $service;
        $this->queryFilter = $queryFilter;
        $this->paginatorInfoFactory = $paginatorInfoFactory;
    }

    public function indexAction()
    {
        try {
            $this->queryFilter->setQueryParameters(
                $this->paginatorInfoFactory->prepareFilterParams($this->params()->fromQuery())
            );

            /** @var PaginatorAdapter $paginator */
            $paginator = $this->service->getFilteredResults(
                $this->queryFilter,
                $hydrationMode = Query::HYDRATE_ARRAY
            );

            $paginatorInfo = $this->paginatorInfoFactory->create($paginator->count());

            $data = array('data' => $paginator->getIterator());
            if ($paginatorInfo->shouldDisplay()) {
                $data['pagination'] = $paginatorInfo->toArray();
            }

            return new JsonModel($data);
        } catch (QueryFilterException $e) {
            throw new Exception\BadRequestException($e->getMessage(), Response::STATUS_CODE_400, $e);
        } catch (PaginationException $e) {
            throw new Exception\BadRequestException($e->getMessage(), Response::STATUS_CODE_400, $e);
        } catch (\PDOException $e) {
            throw new Exception\PDOServiceUnavailableException();
        }
    }
}