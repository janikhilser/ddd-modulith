<?php

declare(strict_types=1);

namespace App\Loan\Infrastructure\Controller;

use App\Common\Infrastructure\Controller\CommandQueryController;
use App\Loan\Application\Query\Publication\GetPublications\GetPublicationQuery;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Throwable;

#[Route('loan/publication/')]
class PublicationController extends CommandQueryController
{
    /**
     * @throws Throwable
     */
    #[Route('', name: 'loan_publication_overview', methods: 'GET')]
    public function index(): Response
    {
        $query = new GetPublicationQuery();

        $publications = $this->ask($query);

        return $this->render('@loan/publication/index.html.twig', [
            'publications' => $publications,
        ]);
    }
}
