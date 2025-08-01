<?php

namespace App\Http\Controllers;

use App\Service\LibraryService;
use App\Transformer\LibraryTransformer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Spatie\Fractalistic\Fractal as Fractalistic;
use League\Fractal\Pagination\PagerfantaPaginatorAdapter;

final class GetAllBooksController extends AbstractController
{
    public function __construct(
        private ResponseFactoryInterface $response,
        private Fractalistic $fractal,
        private LibraryService $service,
    ) {
    }

    public function __invoke(ServerRequestInterface $request, array $args = []) : ResponseInterface
    {
        $paginator = $this->service->getBooks();

        $data = $this->fractal
            ->collection($paginator)
            ->paginateWith(new PagerfantaPaginatorAdapter($paginator, fn (int $page) => $page))
            ->transformWith(LibraryTransformer::class)
            ->toArray();

        return self::json($this->response, $data);
    }
}
