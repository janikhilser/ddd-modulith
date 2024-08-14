<?php

declare(strict_types=1);

namespace App\Loan\Application\Command\Book\Buy;

interface IGetIdByIsbn
{
    public function getIdByIsbn(string $isbn): string;
}
