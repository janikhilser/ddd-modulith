<?php

declare(strict_types=1);

namespace App\Search\Infrastructure\Controller;

use App\Common\Infrastructure\Controller\CommandQueryController;
use App\Search\Application\Command\Book\AddIsbn\AddIsbnCommand;
use App\Search\Application\Command\Book\Create\CreateBookCommand;
use Assert\Assertion;
use Assert\AssertionFailedException;
use Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Throwable;

#[Route('/search/book')]
class EditBookController extends CommandQueryController
{
    /**
     * @throws AssertionFailedException
     * @throws Throwable
     */
    #[Route('/create-book', name: 'search_create_book', methods: 'POST')]
    public function createBook(Request $request): Response
    {
        $isbn = $request->request->getString('isbn');
        $title = $request->request->getString('title');

        Assertion::notEmpty($isbn, 'The isbn is required');
        Assertion::notEmpty($title, 'The title is required');

        $commandRequest = new CreateBookCommand([$isbn], $title);

        try {
            $id = $this->handle($commandRequest);

            return $this->redirectToRoute('search_search_detail', ['id' => $id]);
        } catch (Exception $e) {
            return $this->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    /**
     * @throws AssertionFailedException
     * @throws Throwable
     */
    #[Route('/{id}/add-isbn', name: 'search_add_isbn', methods: 'POST')]
    public function addIsbn(Request $request, string $id): Response
    {
        $isbn = $request->request->getString('isbn');

        Assertion::notEmpty($isbn, 'The isbn is required');

        $commandRequest = new AddIsbnCommand($id, $isbn);

        try {
            $this->handle($commandRequest);

            return $this->redirectToRoute('search_search_detail', ['id' => $id]);
        } catch (Exception $e) {
            return $this->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }
}
