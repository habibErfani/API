<?php

namespace App\Transformer;

use App\Domain\Entity\Library;
use League\Fractal\TransformerAbstract;

final class LibraryTransformer extends TransformerAbstract
{
    public function transform(Library $library) : array
    {
        return [
            'id' => $library->getId(),
            'name' => $library->getName(),
            'chosen' => $library->getChosen(),
            'description' => $library->getDescription(),
            'started' => $library->getStarted()?->format(\DateTimeInterface::ATOM),
            'ended' => $library->getEnded()?->format(\DateTimeInterface::ATOM),
        ];
    }
}
