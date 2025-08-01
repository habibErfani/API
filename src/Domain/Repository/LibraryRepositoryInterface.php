<?php

namespace App\Domain\Repository;

use App\Domain\Entity\Library;
use Pagerfanta\Adapter\AdapterInterface;

interface LibraryRepositoryInterface
{
    public function getAllBooks() : AdapterInterface;

    public function insertBook(Library $library) : void;

    public function deleteBook(string $id) : void;

    public function getBookById(string $id) : ?Library;
}
