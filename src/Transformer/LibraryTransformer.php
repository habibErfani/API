<?php

namespace App\Transformer;

class LibraryTransformer extends \League\Fractal\TransformerAbstract
{
    public function transform(App\Domain\Entity\Library $library) : array
    {
        return [
            'id'         => $library->getId(),
            'name'       => $library->getName(),
            'chosen'     => $library->getChosen(),
            'description'=> $library->getDescription(),
            'started'    => $library->getStarted()->format(\DateTime::ATOM),
            'ended'      => $library->getEnded()->format(\DateTime::ATOM),
        ];
    }
}
