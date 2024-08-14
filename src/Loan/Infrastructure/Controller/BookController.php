<?php

declare(strict_types=1);

namespace App\Loan\Infrastructure\Controller;

use App\Common\Infrastructure\Controller\CommandQueryController;
use App\Loan\Application\Command\Book\Borrow\BorrowBookCommand;
use App\Loan\Application\Command\Book\Buy\BuyBookCommand;
use App\Loan\Application\Command\Book\Return\ReturnBookCommand;
use App\Loan\Application\Query\Book\GetBookById\GetBookByIdQuery;
use App\Loan\Application\Query\Book\GetBooks\GetBooksQuery;
use Assert\Assertion;
use Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Throwable;

#[Route('loan/book/')]
class BookController extends CommandQueryController
{
    /**
     * @throws Throwable
     */
    #[Route('', name: 'loan_book_overview')]
    public function index(): Response
    {
        $query = new GetBooksQuery();

        $books = $this->ask($query);

        return $this->render('@loan/book/index.html.twig', [
            'books' => $books,
        ]);
    }

    #[Route('buy', name: 'loan_book_show_buy', methods: 'GET')]
    public function showBuy(): Response
    {
        return $this->render('@loan/book/buy.html.twig');
    }

    /**
     * @throws Throwable
     */
    #[Route('buy', name: 'loan_book_buy', methods: 'POST')]
    public function kaufen(Request $request): Response
    {
        $isbn = $request->request->getString('isbn');
        $anzahl = $request->request->getInt('count');

        Assertion::notEmpty($isbn, 'The ISBN is empty.');
        Assertion::greaterThan($anzahl, 0, 'The ISBN has to be greater than 0.');

        try {
            for ($i = 0; $i < $anzahl; ++$i) {
                $this->handle(new BuyBookCommand($isbn));
            }

            return $this->redirectToRoute('loan_book_overview');
        } catch (Exception $e) {
            return $this->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    /**
     * @throws Throwable
     */
    #[Route('borrow/{id}', name: 'loan_book_borrow', methods: 'POST')]
    public function borrow(string $id): Response
    {
        Assertion::notEmpty($id, 'The ID is empty.');

        $command = new BorrowBookCommand($id);
        $this->handle($command);

        return $this->redirectToRoute('loan_book_detail', ['id' => $id]);
    }

    /**
     * @throws Throwable
     */
    #[Route('return/{id}', name: 'loan_book_return', methods: 'POST')]
    public function return(string $id): Response
    {
        Assertion::notEmpty($id, 'The ID is empty.');

        $command = new ReturnBookCommand($id);
        $this->handle($command);

        return $this->redirectToRoute('loan_book_detail', ['id' => $id]);
    }

    /**
     * @throws Throwable
     */
    #[Route('{id}', name: 'loan_book_detail', methods: 'GET')]
    public function detail(string $id): Response
    {
        $query = new GetBookByIdQuery($id);

        $book = $this->ask($query);

        return $this->render('@loan/book/detail.html.twig', [
            'book' => $book,
        ]);
    }
}
