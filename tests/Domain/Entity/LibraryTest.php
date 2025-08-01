<?php

namespace App\Test\Domain\Entity;

use Faker\Factory;
use Faker\Generator;
use App\Domain\Entity\Library;
use PHPUnit\Framework\TestCase;

class LibraryTest extends TestCase
{
    private Library $library;
    private Generator $generator;

    protected function setUp() : void
    {
        $this->generator = Factory::create();

        $this->library = new Library(
            $this->generator->name,
            $this->generator->paragraph,
            new \DateTime('2023-02-26'),
            new \DateTime('2023-03-26')
        );
    }

    public function testGetId() : void
    {
        $id = $this->library->getId();

        self::assertNotNull($id);

        self::assertIsString($id);

        self::assertSame($id, $this->library->getId());
    }

    public function testGetNameAndSetName() : void
    {
        $name = $this->library->getName();

        $this->library->setName($this->generator->name);

        self::assertNotSame($name, $this->library->getName());
    }

    public function testTook() : void
    {
        $book = $this->generator->name;
        $this->library->took($book);

        self::assertNotNull($this->library->getChosen());

        self::assertSame($book, $this->library->getChosen()[0]);
    }

    public function testDescriptions() : void
    {
        $this->library->setDescription('Best Book');

        self::assertSame('Best Book', $this->library->getDescription());
    }
}
