<?php

namespace App\Repository;

use App\Domain\Entity\Library;
use Doctrine\ORM\EntityManager;
use Pagerfanta\Adapter\AdapterInterface;
use Pagerfanta\Doctrine\ORM\QueryAdapter;

final class LibraryRepository implements \App\Domain\Repository\LibraryRepositoryInterface
{
    public function __construct(private EntityManager $entityManager)
    {
    }

    public function getAllBooks() : AdapterInterface
    {
        $repository = $this->entityManager->getRepository(Library::class);
        $query      = $repository->createQueryBuilder('library');

        return new QueryAdapter($query);
    }

    public function insertBook(Library $library) : void
    {
        $this->entityManager->persist($library);
        $this->entityManager->flush();
    }

    public function deleteBook(string $id) : void
    {
        $book = $this->getBookById($id);

        if (!$book instanceof Library) {
            throw new \Exception('Book not found');
        }
        $this->entityManager->remove($book);
        $this->entityManager->flush();
    }

    public function getBookById(string $id) : ?Library
    {
        return $this->entityManager->find(Library::class, $id);
    }
}
