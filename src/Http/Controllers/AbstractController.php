<?php

namespace App\Http\Controllers;

use Psr\Http\Message\ResponseInterface;
use Fig\Http\Message\StatusCodeInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseFactoryInterface;

abstract class AbstractController implements StatusCodeInterface
{
    abstract public function __invoke(ServerRequestInterface $request, array $args = []) : ResponseInterface;

    /**
     * Json helper.
     */
    public static function json(ResponseFactoryInterface $response_factory, mixed $data = [], int $status = 200) : ResponseInterface
    {
        $response = $response_factory->createResponse($status);

        $body = $response->getBody();
        $body->rewind();
        $body->write(json_encode($data, \JSON_THROW_ON_ERROR));

        return $response->withHeader('Content-Type', 'application/json;charset=utf-8');
    }
}
