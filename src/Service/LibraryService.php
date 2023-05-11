<?php

namespace App\Service;

use Pagerfanta\Pagerfanta;
use App\Domain\Entity\Library;

class LibraryService
{
    public function __construct(private \App\Domain\Repository\LibraryRepositoryInterface $repository,
    ) {
    }

    public function add(Library $library) : void
    {
        $this->repository->insertBook($library);
    }

    public function deleteById(string $id) : void
    {
        $this->repository->deleteBook($id);
    }

    public function getBooks() : Pagerfanta
    {
        return new Pagerfanta($this->repository->getAllBooks());
    }

    public function getBookById(string $id) : Pagerfanta
    {
        $book = $this->repository->getBookById($id);

        return new Pagerfanta($book);
    }
}
