<?php

namespace BusinessLogic\BooksTest\Entity\Provider;

use BusinessLogic\Books\Entity\BookEntity;
use Test\Bootstrap;

class BookEntityProvider
{
    /**
     * @param bool $withRandomId
     *
     * @return BookEntity
     */
    public function getBookEntityWithRandomData($withRandomId = true)
    {
        $bookEntity = new BookEntity();
        $bookEntity->setTitle(uniqid('title'))
            ->setDescription(uniqid('description'))
            ->setPublisher(uniqid('publisher'))
            ->setYear(mt_rand(1900, date('Y')))
            ->setPrice(mt_rand(1, 10000) / 100)
            ->setIsbn($this->getIsbn13Random());

        if ($withRandomId) {
            Bootstrap::setIdToEntity($bookEntity, mt_rand(1, 999));
        }

        return $bookEntity;
    }

    private function getIsbn13Random()
    {
        $pattern = '%s%s%s-%s%s-%s%s%s-%s%s%s%s-%s';

        $isbn = [];
        $sum = 0;
        for ($i = 1; $i < 13; $i += 1) {
            $index = mt_rand(0, 9);
            if ($i % 2 === 0) {
                $sum += $index * 3;
            } else {
                $sum += $index;
            }
            $isbn[] = $index;
        }

        $modulo = $sum % 10;
        $isbn[] = ($modulo > 0) ? 10 - $modulo : 0;

        return vsprintf($pattern, $isbn);
    }

    /**
     * @param BookEntity $bookEntity
     * @param bool       $withId
     *
     * @return array
     */
    public function getDataFromBookEntity(BookEntity $bookEntity, $withId = true)
    {
        $data = [];

        if ($withId && $bookEntity->getId()) {
            $data['id'] = $bookEntity->getId();
        }

        $data = [
            'title' => $bookEntity->getTitle(),
            'description' => $bookEntity->getDescription(),
            'isbn' => $bookEntity->getIsbn(),
            'year' => $bookEntity->getYear(),
            'publisher' => $bookEntity->getPublisher(),
            'price' => $bookEntity->getPrice()
        ];

        return $data;
    }
}