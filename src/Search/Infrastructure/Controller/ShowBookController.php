<?php

declare(strict_types=1);

namespace App\Search\Infrastructure\Controller;

use App\Common\Application\Command\ICommandBus;
use App\Common\Application\Query\IQueryBus;
use App\Common\Infrastructure\Controller\CommandQueryController;
use App\Search\Application\Query\Book\GetBookById\GetBookByIdQuery;
use App\Search\Application\Query\Book\GetBooks\GetBooksQuery;
use App\Search\Application\Query\Book\GetBooksByTitle\GetBooksByTitleQuery;
use App\Search\Application\Query\Book\GetIdByIsbn\GetIdByIsbnQuery;
use App\Search\Domain\Book\ValueObject\BookId;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use Symfony\Component\Routing\Annotation\Route;
use Throwable;

#[Route('/search/book')]
class ShowBookController extends CommandQueryController
{
    public function __construct(
        ICommandBus $commandBus,
        IQueryBus $queryBus
    ) {
        parent::__construct($commandBus, $queryBus);
    }

    /**
     * @throws Throwable
     */
    #[Route('/search', name: 'search_book_overview')]
    public function index(Request $request): Response
    {
        $title = $request->query->get('title');

        $query = empty($title) ? new GetBooksQuery() : new GetBooksByTitleQuery($title);

        $results = $this->ask($query);

        return $this->render('@search/search/index.html.twig', [
            'results' => $results,
        ]);
    }

    /**
     * @throws Throwable
     */
    #[Route('/detail', name: 'search_detail_by_isbn', methods: 'GET')]
    public function detailByIsbn(
        #[MapQueryParameter] string $isbn
    ): Response {
        $query = new GetIdByIsbnQuery($isbn);

        /** @var BookId $bookId */
        $bookId = $this->ask($query);

        return $this->redirectToRoute('search_search_detail', ['id' => $bookId->getId()]);
    }

    /**
     * @throws Throwable
     */
    #[Route('/{id}', name: 'search_search_detail', methods: 'GET')]
    public function detail(string $id): Response
    {
        $query = new GetBookByIdQuery($id);

        $book = $this->ask($query);

        return $this->render('@search/search/detail.html.twig', [
            'book' => $book,
        ]);
    }
}
