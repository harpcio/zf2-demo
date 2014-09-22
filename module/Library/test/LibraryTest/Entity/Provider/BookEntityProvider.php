<?php

namespace LibraryTest\Entity\Provider;

use Library\Entity\BookEntity;
use Test\Bootstrap;

class BookEntityProvider
{
    /**
     * @return BookEntity
     */
    public function getBookEntityWithRandomData()
    {
        $bookEntity = new BookEntity();
        $bookEntity->setTitle(uniqid('title'))
            ->setDescription(uniqid('description'))
            ->setPublisher(uniqid('publisher'))
            ->setYear(mt_rand(1900, date('Y')))
            ->setPrice(mt_rand(1, 10000) / 100)
            ->setIsbn($this->getIsbn13Random());

        Bootstrap::setIdToEntity($bookEntity, mt_rand(1, 999));

        return $bookEntity;
    }

    private function getIsbn13Random()
    {
        $pattern = '%s%s%s-%s%s-%s%s%s-%s%s%s%s-%s';

        $isbn = [];
        $sum = 0;
        for ($i = 0; $i < 12; $i += 1) {
            $index = mt_rand(0, 9);
            if ($i % 2 === 0) {
                $sum += $index * 3;
            } else {
                $sum += $index;
            }
            $isbn[] = $index;
        }

        $isbn[] = 10 - ($sum % 10);

        return vsprintf($pattern, $isbn);
    }

    /**
     * @param BookEntity $bookEntity
     *
     * @return array
     */
    public function getDataFromBookEntity(BookEntity $bookEntity)
    {
        $data = [
            'id' => $bookEntity->getId(),
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