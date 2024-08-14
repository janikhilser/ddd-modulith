<?php

declare(strict_types=1);

namespace App\Common\Infrastructure\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class NotFoundController extends AbstractController
{
    public function index(): Response
    {
        // Hier kannst du deine benutzerdefinierte Ansicht für nicht gefundene Seiten rendern
        return $this->render('@common/not_found.html.twig');
    }
}
