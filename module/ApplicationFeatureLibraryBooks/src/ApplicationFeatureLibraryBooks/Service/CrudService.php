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

namespace ApplicationFeatureLibraryBooks\Service;

use Doctrine\ORM\EntityNotFoundException;
use BusinessLogicDomainBooks\Entity\BookEntity;
use BusinessLogicDomainBooks\Repository\BooksRepositoryInterface;
use Zend\InputFilter\InputFilterInterface;

class CrudService
{
    /**
     * @var BooksRepositoryInterface
     */
    private $bookRepository;

    public function __construct(BooksRepositoryInterface $bookRepository)
    {
        $this->bookRepository = $bookRepository;
    }

    /**
     * @param InputFilterInterface $filter
     *
     * @return BookEntity
     * @throws \LogicException
     */
    public function create(InputFilterInterface $filter)
    {
        if (!$filter->isValid()) {
            throw new \LogicException('Form is not valid!');
        }

        $data = $filter->getValues();
        $newBookEntity = $this->bookRepository->createNewEntity();
        $bookEntity = $this->bookRepository->hydrate($newBookEntity, $data);

        $this->bookRepository->save($bookEntity);

        return $bookEntity;
    }

    /**
     * @param BookEntity           $bookEntity
     * @param InputFilterInterface $filter
     *
     * @throws \LogicException
     * @return BookEntity
     */
    public function update(BookEntity $bookEntity, InputFilterInterface $filter)
    {
        if (!$filter->isValid()) {
            throw new \LogicException('Form is not valid!');
        }

        $data = $filter->getValues();
        $bookEntity = $this->bookRepository->hydrate($bookEntity, $data);

        $this->bookRepository->save($bookEntity);

        return $bookEntity;
    }

    /**
     * @param BookEntity $bookEntity
     *
     * @throws \LogicException
     * @return BookEntity
     */
    public function delete(BookEntity $bookEntity)
    {
        $this->bookRepository->delete($bookEntity);
    }

    /**
     * @param int $id
     *
     * @throws \Doctrine\ORM\EntityNotFoundException
     * @throws \InvalidArgumentException
     * @return BookEntity
     */
    public function getById($id)
    {
        if (empty($id)) {
            throw new \InvalidArgumentException('ID cannot be empty');
        }

        if (!($bookEntity = $this->bookRepository->find((int)$id))) {
            throw new EntityNotFoundException(sprintf('Books entity specified by ID "%s" cannot be found', $id));
        }

        return $bookEntity;
    }

    /**
     * @param BookEntity $bookEntity
     *
     * @return array
     */
    public function extractEntity(BookEntity $bookEntity)
    {
        return $this->bookRepository->extract($bookEntity);
    }

}