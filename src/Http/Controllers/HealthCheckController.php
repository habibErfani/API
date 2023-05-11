<?php

namespace App\Http\Controllers;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseFactoryInterface;

class HealthCheckController
{
    public function __construct(
        private ResponseFactoryInterface $response_factory
    ) {
    }

    public function __invoke(ServerRequestInterface $request, array $args = []) : ResponseInterface
    {
        return $this->response_factory->createResponse(200, 'HealthCheck works');
    }
}
