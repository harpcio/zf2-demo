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

namespace ApplicationFeatureLibraryBooks\Controller;

use ApplicationFeatureLibraryBooks\Service\CrudService;
use Zend\Mvc\Controller\AbstractActionController;

class ReadController extends AbstractActionController
{
    public function __construct(CrudService $service)
    {
        $this->service = $service;
    }

    public function indexAction()
    {
        $id = $this->params()->fromRoute('id', null);

        try {
            $bookEntity = $this->service->getById($id);
        } catch (\Exception $e) {
            $this->flashMessenger()->addErrorMessage($e->getMessage());

            return $this->redirect()->toRoute('library/books');
        }

        return [
            'book' => $bookEntity,
        ];
    }
}