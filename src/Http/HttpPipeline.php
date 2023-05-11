<?php

namespace App\Http;

use League\Route\Router;
use Middlewares\JsonPayload;
use Laminas\Di\InjectorInterface;
use Psr\Container\ContainerInterface;
use League\Route\Strategy\JsonStrategy;
use Laminas\Di\Exception\ExceptionInterface;
use League\Route\Strategy\StrategyInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Container\NotFoundExceptionInterface;
use Psr\Container\ContainerExceptionInterface;
use App\Http\Controllers\GetAllBooksController;
use App\Http\Controllers\HealthCheckController;

class HttpPipeline implements RequestHandlerInterface
{
    public function __construct(
        private ContainerInterface $container
    ) {
    }

    /**
     * @throws NotFoundExceptionInterface
     * @throws ExceptionInterface
     * @throws ContainerExceptionInterface
     */
    public function handle(ServerRequestInterface $request) : \Psr\Http\Message\ResponseInterface
    {
        $router = new Router();

        // Injector responsible for auto wiring strategy which implements constructor injection
        $injector = $this->container->get(InjectorInterface::class);
        if (!($injector instanceof InjectorInterface)) {
            throw new \Exception("Injector must be an instance of Di\InjectorInterface");
        }

        $strategy = $injector->create(JsonStrategy::class);
        \assert($strategy instanceof StrategyInterface);
        $router->setStrategy($strategy);

        // json payload
        $router->middleware(new JsonPayload());

        $router->get('/health', $injector->create(HealthCheckController::class));
        $router->get('/', $injector->create(GetAllBooksController::class));

        return $router->dispatch($request);
    }
}
