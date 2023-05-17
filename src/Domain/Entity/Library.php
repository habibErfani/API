<?php

namespace App\Domain\Entity;

use Ramsey\Uuid\Uuid;

class Library
{
    private string $id;
    private string $name;
    private ?array $chosen;
    private string $description;
    private ?\DateTime $started;
    private ?\DateTime $ended;

    public function __construct(
        string $name,
        string $description,
        \DateTime $started = null,
        \DateTime $ended = null
    ) {
        $this->id          = Uuid::uuid4()->toString();
        $this->name        = $name;
        $this->chosen      = [];
        $this->description = $description;
        $this->started     = $started;
        $this->ended       = $ended;
        \assert($started < $ended, 'Started must be higher than ended');
    }

    public function getId() : string
    {
        return $this->id;
    }

    public function getName() : string
    {
        return $this->name;
    }

    public function setName(string $name) : void
    {
        $this->name = $name;
    }

    public function getChosen() : ?array
    {
        return $this->chosen;
    }

    public function setChosen(?array $chosen) : void
    {
        $this->chosen = $chosen;
    }

    public function getDescription() : string
    {
        return $this->description;
    }

    public function setDescription(string $description) : void
    {
        $this->description = $description;
    }

    public function getStarted() : ?\DateTime
    {
        return $this->started;
    }

    public function setStarted(?\DateTime $started) : void
    {
        $this->started = $started;
    }

    public function getEnded() : ?\DateTime
    {
        return $this->ended;
    }

    public function setEnded(?\DateTime $ended) : void
    {
        $this->ended = $ended;
    }

    public function took(string $name) : void
    {
        $this->chosen = [$name];
    }
}
