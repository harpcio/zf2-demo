<?php

namespace Library\Service\Book;

use Doctrine\ORM\EntityNotFoundException;
use Library\Entity\BookEntity;
use Library\Repository\BookRepositoryInterface;
use Zend\InputFilter\InputFilterInterface;

class CrudService
{
    /**
     * @var BookRepositoryInterface
     */
    private $bookRepository;

    public function __construct(BookRepositoryInterface $bookRepository)
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

        $data          = $filter->getValues();
        $newBookEntity = $this->bookRepository->createNewEntity();
        $bookEntity    = $this->bookRepository->hydrate($newBookEntity, $data);

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

        $data       = $filter->getValues();
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
            throw new EntityNotFoundException(sprintf('Book entity specified by ID "%s" cannot be found', $id));
        }

        return $bookEntity;
    }

    /**
     * @param BookEntity $bookEntity
     *
     * @return array
     */
    public function hydrateEntity(BookEntity $bookEntity)
    {
        return $this->bookRepository->extract($bookEntity);
    }

    /**
     * @return BookEntity[]
     */
    public function getAll()
    {
        return $this->bookRepository->findAll();
    }
}